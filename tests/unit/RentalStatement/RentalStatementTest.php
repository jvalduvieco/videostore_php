<?php
namespace VideoStore\Tests\Unit\RentalStatement;

use VideoStore\ChildrensMovie;
use VideoStore\Movie;
use VideoStore\NewReleaseMovie;
use VideoStore\RegularMovie;
use VideoStore\Rental;
use VideoStore\RentalStatement\RentalStatement;

class RentalStatementTest extends \PHPUnit_Framework_TestCase
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

    public function testMultipleRentalStatement()
    {
        $this->statement->addRental(new Rental($this->newRelease, 1));
        $this->statement->addRental(new Rental($this->childrens, 2));
        $this->statement->addRental(new Rental($this->regular, 3));

        $this->assertEquals(8, $this->statement->getAmountOwed(), "Amount owed not do not match");
        $this->assertEquals(3, $this->statement->getFrequentRenterPoints(), "Frequent renter points do not match");
    }

    protected function setUp()
    {
        $this->statement = new RentalStatement("Customer Name");
        $this->newRelease = new NewReleaseMovie("New Release 1");
        $this->childrens = new ChildrensMovie("Childrens");
        $this->regular = new RegularMovie("Regular 3");
    }
}