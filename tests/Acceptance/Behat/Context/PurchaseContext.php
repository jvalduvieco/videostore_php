<?php
namespace VideoStore\Tests\Acceptance\Behat\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use VideoStore\Customer\Customer;
use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

class PurchaseContext implements Context
{
    /** @var  Customer */
    private $customer;

    /** @var MovieRenter */
    private $renter;

    /** @var  RentalStatement */
    private $statement;

    /** @var RentalStatementStringPrinter */
    private $statementStringPrinter;

    /**
     * PurchaseContext constructor.
     */
    public function __construct()
    {
        $this->renter = MovieRenter::createDefaultRenter();
        $this->statementStringPrinter = new RentalStatementStringPrinter();
    }


    /**
     * @Given /^I sign up as giving my name "([^"]*)"$/
     */
    public function iSignUpAsGivingMyName($customerName)
    {
        $this->customer = new Customer($customerName);
    }

    /**
     * @Given then I rent the following movies
     * @param TableNode $table
     */
    public function thenIRentTheFollowingMovies(TableNode $table)
    {
        $this->statement = new RentalStatement($this->customer);
        foreach ($table->getColumnsHash() as $movieToBeRented) {
            $category = MovieCategory::fromString($movieToBeRented['type']);
            $movie = new Movie($movieToBeRented['title'], $category);
            $this->statement->addRental($this->renter->rentAMovie($movie, $movieToBeRented['days']));
        }
    }

    /**
     * @When I request my rental statement
     */
    public function iRequestMyRentalStatement()
    {
    }

    /**
     * @Then I shoud see the next report
     * @param PyStringNode $string
     */
    public function iShoudSeeTheNextReport(PyStringNode $string)
    {
        $expected = $string->getRaw();
        $tested = $this->statementStringPrinter->makeRentalStatement($this->statement);
        Assertion::same($expected, $tested);
    }

    /**
     * @Given The following strategies to calculate frequent renter points and rental amount are present in the catalog:
     * @param TableNode $table
     */
    public function theFollowingStrategiesToCalculateFrequentRenterPointsAndRentalAmountArePresentInTheCatalog(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given the following strategies to calculate rental amount:
     * @param TableNode $table
     */
    public function theFollowingStrategiesToCalculateRentalAmount(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given the following movies are in the videostore catalog:
     * @param TableNode $table
     */
    public function theFollowingMoviesAreInTheVideostoreCatalog(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When I rent the following movies
     * @param TableNode $table
     */
    public function iRentTheFollowingMovies(TableNode $table)
    {
        throw new PendingException();
    }
}