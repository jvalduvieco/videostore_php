<?php
namespace VideoStore\Tests\Integration;

use VideoStore\Customer\Customer;
use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

class VideoStoreTest extends \PHPUnit_Framework_TestCase
{
    /** @var RentalStatement */
    private $statement;
    /** @var MovieRenter */
    private $renter;
    /** @var Movie */
    private $newRelease1;
    /** @var Movie */
    private $newRelease2;
    /** @var Movie */
    private $childrens;
    /** @var Movie */
    private $regular1;
    /** @var Movie */
    private $regular2;
    /** @var Movie */
    private $regular3;
    /** @var  RentalStatementStringPrinter */
    private $statementStringPrinter;

    public function testSingleNewReleaseStatement()
    {
        $this->statement->addRental($this->renter->rentAMovie($this->newRelease1, 3));

        $this->assertAmountAndPointsForReport(9.0, 2);
    }

    private function assertAmountAndPointsForReport(float $expectedAmount, int $expectedPoints)
    {
        $this->assertEquals($expectedAmount, $this->statement->getAmountOwed(), "Amount owed not do not match");
        $this->assertEquals($expectedPoints, $this->statement->getFrequentRenterPoints(), "Frequent renter points do not match");
    }

    public function testDualNewReleaseStatement()
    {
        $this->statement->addRental($this->renter->rentAMovie($this->newRelease1, 3));
        $this->statement->addRental($this->renter->rentAMovie($this->newRelease2, 3));
        $this->assertAmountAndPointsForReport(18.0, 4);
    }

    public function testSingleChildrensStatement()
    {
        $this->statement->addRental($this->renter->rentAMovie($this->childrens, 3));
        $this->assertAmountAndPointsForReport(1.5, 1);
    }

    public function testMultipleRegularStatement()
    {
        $this->statement->addRental($this->renter->rentAMovie($this->regular1, 1));
        $this->statement->addRental($this->renter->rentAMovie($this->regular2, 2));
        $this->statement->addRental($this->renter->rentAMovie($this->regular3, 3));
        $this->assertAmountAndPointsForReport(7.5, 3);
    }

    public function testRentalStatementFormat()
    {
        $this->statement->addRental($this->renter->rentAMovie($this->regular1, 1));
        $this->statement->addRental($this->renter->rentAMovie($this->regular2, 2));
        $this->statement->addRental($this->renter->rentAMovie($this->regular3, 3));

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tRegular 1\t2.0\n" .
            "\tRegular 2\t2.0\n" .
            "\tRegular 3\t3.5\n" .
            "You owed 7.5\n" .
            "You earned 3 frequent renter points\n",
            $this->statementStringPrinter->makeRentalStatement($this->statement));
    }

    protected function setUp()
    {
        $this->statement = new RentalStatement(Customer::findByName("Customer Name"));
        $this->newRelease1 = new Movie("New Release 1", MovieCategory::newRelease());
        $this->newRelease2 = new Movie("New Release 2", MovieCategory::newRelease());
        $this->childrens = new Movie("Childrens", MovieCategory::children());
        $this->regular1 = new Movie("Regular 1", MovieCategory::regular());
        $this->regular2 = new Movie("Regular 2", MovieCategory::regular());
        $this->regular3 = new Movie("Regular 3", MovieCategory::regular());
        $this->renter = MovieRenter::createDefaultRenter();
        $this->statementStringPrinter = new RentalStatementStringPrinter();
    }
}