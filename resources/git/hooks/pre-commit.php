#!/usr/bin/php
<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\ProcessBuilder;

class CodeQualityTool extends Application
{
    const PHP_FILES_IN_SRC = '/.*\/src\/(.*)(\.php)$/';
    /** @var  OutputInterface */
    private $output;
    /** @var  InputInterface */
    private $input;
    /** @var  string[] */
    private $files;
    /** @var string */
    private $rootPath;

    public function __construct()
    {
        parent::__construct('Code Quality Tool', '1.0.0');
        $this->rootPath = realpath(__DIR__ . '/../../../');
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        if ($input->getFirstArgument() == "check-now") {
            $this->files = $this->extractAllFilesInFolderRecursivelyFilteringByName(
                array(
                    $this->rootPath . "/src",
                    $this->rootPath . "/tests"
                ),
                "*.php");
        } else {
            $this->files = $this->extractCommitedFiles();
        }

        if ($this->isProcessingAnyPhpFile()) {
            $this->checkComposerJsonAndLockSync();
            $this->checkPhpSyntaxWithLint();
            $this->checkCodeStyleWithCsFixer();
            $this->checkCodeStyleWithCodeSniffer();
            $this->checkPhpMessDetection();
            $this->checkUnitTestsArePassing();
        }

        $this->output->writeln('<info>Good job dude!</info>');
    }

    private function extractAllFilesInFolderRecursivelyFilteringByName(array $folders, string $nameFilter): array
    {
        $finder = new Finder();
        $finder->files()->in($folders)->name($nameFilter);
        return array_map(function ($file) {
            return $file->__toString();
        }, iterator_to_array($finder->files(), false));
    }

    private function extractCommitedFiles()
    {
        $this->output->writeln('<fg=white;options=bold;bg=red>Code Quality Tool</fg=white;options=bold;bg=red>');
        $this->output->writeln('<info>Fetching files</info>');

        $output = array();
        $rc = 0;

        exec('git rev-parse --verify HEAD 2> /dev/null', $output, $rc);

        $against = '11c8603372b90e50c7154315c873bca73b1236e5';
        if ($rc == 0) {
            $against = 'HEAD';
        }

        exec("git diff-index --cached --name-status $against | egrep '^(A|M)' | awk '{print $2;}'", $output);

        return $output;
    }

    private function isProcessingAnyPhpFile()
    {
        return $this->isAnyFileMatching(function ($aFile) {
            return preg_match(self::PHP_FILES_IN_SRC, $aFile);
        });
    }

    private function isAnyFileMatching($aMatcherFunction)
    {
        foreach ($this->files as $file) {
            $isPhpFile = $aMatcherFunction($file);
            if ($isPhpFile) {
                return true;
            }
        }

        return false;
    }

    private function checkComposerJsonAndLockSync()
    {
        $this->output->writeln('<info>Check composer</info>');

        $composerJsonDetected = false;
        $composerLockDetected = false;

        foreach ($this->files as $file) {
            if ($file === 'composer.json') {
                $composerJsonDetected = true;
            }

            if ($file === 'composer.lock') {
                $composerLockDetected = true;
            }
        }

        if ($composerJsonDetected && !$composerLockDetected) {
            throw new Exception('composer.lock must be commited if composer.json is modified!');
        }
    }

    private function checkPhpSyntaxWithLint()
    {
        $this->checkCodeStyleWith(
            'PHPLint',
            ['php', '-l'],
            '/(\.php)|(\.inc)$/'
        );
    }

    private function checkCodeStyleWith($aLintingTool, $someParams, $aFilePattern)
    {
        $this->output->writeln('<info>Checking code style with ' . $aLintingTool . '</info>');

        $succeed = true;

        foreach ($this->files as $file) {
            if (!preg_match($aFilePattern, $file)) {
                continue;
            }
            array_push($someParams, $file);
            $processBuilder = new ProcessBuilder($someParams);
            $processBuilder->setWorkingDirectory(__DIR__ . '/../../../');
            $lintingProcess = $processBuilder->getProcess();
            $lintingProcess->run();

            if (!$lintingProcess->isSuccessful()) {
                $this->output->writeln($file);
                $this->output->writeln(sprintf('<error>%s</error>', trim($lintingProcess->getOutput())));

                if ($succeed) {
                    $succeed = false;
                }
            }
        }

        if (!$succeed) {
            throw new Exception(sprintf('There are ' . $aLintingTool . ' coding standards violations!'));
        }
    }

    private function checkCodeStyleWithCsFixer()
    {
        $this->output->writeln('<info>Checking code style</info>');

        $succeed = true;
        foreach ($this->files as $file) {
            $srcFile = preg_match(self::PHP_FILES_IN_SRC, $file);

            if (!$srcFile) {
                continue;
            }

            $fixers = '';

            $processBuilder = new ProcessBuilder([
                    'php',
                    'vendor/friendsofphp/php-cs-fixer/php-cs-fixer',
                    '--dry-run',
                    '--using-cache=no',
                    '--verbose',
                    'fix',
                    $file,
                    '--rules=@PSR2'
                ] + ($fixers ? ['--fixers=' . $fixers] : []));

            $processBuilder->setWorkingDirectory(__DIR__ . '/../../../');
            $phpCsFixer = $processBuilder->getProcess();
            $phpCsFixer->run();

            if (!$phpCsFixer->isSuccessful()) {
                $this->output->writeln(sprintf('<error>%s</error>', trim($phpCsFixer->getOutput())));

                if ($succeed) {
                    $succeed = false;
                }
            }
        }

        if (!$succeed) {
            throw new Exception(sprintf('There are coding standards violations!'));
        }
    }

    private function checkCodeStyleWithCodeSniffer()
    {
        $this->checkCodeStyleWith(
            'PHPCS',
            ['php', 'vendor/squizlabs/php_codesniffer/scripts/phpcs', '--standard=PSR2'],
            self::PHP_FILES_IN_SRC
        );
    }

    private function checkPhpMessDetection()
    {
        $this->output->writeln('<info>Checking code mess with PHPMD</info>');

        $needle = self::PHP_FILES_IN_SRC;
        $succeed = true;

        foreach ($this->files as $file) {
            if (!preg_match($needle, $file)) {
                continue;
            }

            $processBuilder = new ProcessBuilder([
                'php',
                'vendor/phpmd/phpmd/src/bin/phpmd',
                $file,
                'text',
                $this->rootPath . '/resources/codingStandard/phpmd/webflixPmdRules.xml',
                '--minimumpriority',
                1
            ]);
            $processBuilder->setWorkingDirectory($this->rootPath);
            $process = $processBuilder->getProcess();
            $process->run();

            if (!$process->isSuccessful()) {
                $this->output->writeln($file);
                $this->output->writeln(sprintf('<error>%s</error>', trim($process->getErrorOutput())));
                $this->output->writeln(sprintf('<info>%s</info>', trim($process->getOutput())));
                if ($succeed) {
                    $succeed = false;
                }
            }
        }

        if (!$succeed) {
            throw new Exception(sprintf('There are PHPMD violations!'));
        }
    }

    private function checkUnitTestsArePassing()
    {
        $this->output->writeln('<info>Running unit tests</info>');

        $processBuilder = new ProcessBuilder(array('php', 'vendor/phpunit/phpunit/phpunit'));
        $processBuilder->setWorkingDirectory(__DIR__ . '/../../../');
        $processBuilder->setTimeout(3600);
        $phpunit = $processBuilder->getProcess();

        $phpunit->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (!$phpunit->isSuccessful()) {
            throw new Exception('Fix the fucking unit tests!');
        }
    }
}

$console = new CodeQualityTool();
$console->run();
