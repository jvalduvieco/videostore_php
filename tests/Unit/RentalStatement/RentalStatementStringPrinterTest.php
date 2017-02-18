<?php
namespace VideoStore\Tests\Unit\RentalStatement;

use VideoStore\Customer\Customer;
use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;
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

    /** @var  MovieRenter */
    private $movireRenter;

    /** @var  Customer */
    private $customer;

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
        $this->statement->addRental($this->movireRenter->rentAMovie($this->newRelease, 1));

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tNew Release 1\t3.0\n" .
            "You owed 3\n" .
            "You earned 1 frequent renter points\n",
            $this->rentalStatementStringPrinter->makeRentalStatement($this->statement));
    }

    public function testMultipleRentalStatementStringConversion()
    {
        $this->statement->addRental($this->movireRenter->rentAMovie($this->newRelease, 1));
        $this->statement->addRental($this->movireRenter->rentAMovie($this->childrens, 2));
        $this->statement->addRental($this->movireRenter->rentAMovie($this->regular, 3));

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
        $this->customer = new Customer("Customer Name");
        $this->statement = new RentalStatement($this->customer);
        $this->newRelease = new Movie("New Release 1", MovieCategory::newRelease());
        $this->childrens = new Movie("Childrens", MovieCategory::children());
        $this->regular = new Movie("Regular 3", MovieCategory::regular());
        $this->movireRenter = MovieRenter::createDefaultRenter();
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
    }
}