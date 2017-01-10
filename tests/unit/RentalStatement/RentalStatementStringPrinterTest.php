<?php
namespace VideoStore\Tests\Unit\RentalStatement;

use VideoStore\Movie\ChildrensMovie;
use VideoStore\Movie\Movie;
use VideoStore\Movie\NewReleaseMovie;
use VideoStore\Movie\RegularMovie;
use VideoStore\Rental;
use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

class RentalStatementStringPrinterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RentalStatement
     */
    private $statement;
    /**
     * @var Movie
     */
    private $newRelease;
    /**
     * @var Movie
     */
    private $childrens;
    /**
     * @var Movie
     */
    private $regular;

    /**
     * @var RentalStatementStringPrinter
     */
    private $rentalStatementStringPrinter;

    public function testEmptyRentalStatementStringConversion()
    {

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "You owed 0\n" .
            "You earned 0 frequent renter points\n",
            $this->rentalStatementStringPrinter->makeRentalStatement($this->statement));
    }

    public function testSingleRentalStatementStringConversion()
    {
        $this->statement->addRental(new Rental($this->newRelease, 1));

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tNew Release 1\t3.0\n" .
            "You owed 3\n" .
            "You earned 1 frequent renter points\n",
            $this->rentalStatementStringPrinter->makeRentalStatement($this->statement));
    }

    public function testMultipleRentalStatementStringConversion()
    {
        $this->statement->addRental(new Rental($this->newRelease, 1));
        $this->statement->addRental(new Rental($this->childrens, 2));
        $this->statement->addRental(new Rental($this->regular, 3));

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tNew Release 1\t3.0\n" .
            "\tChildrens\t1.5\n" .
            "\tRegular 3\t3.5\n" .
            "You owed 8\n" .
            "You earned 3 frequent renter points\n",
            $this->rentalStatementStringPrinter->makeRentalStatement($this->statement));
    }

    protected function setUp()
    {
        $this->statement = new RentalStatement("Customer Name");
        $this->newRelease = new NewReleaseMovie("New Release 1");
        $this->childrens = new ChildrensMovie("Childrens");
        $this->regular = new RegularMovie("Regular 3");
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
    }
}