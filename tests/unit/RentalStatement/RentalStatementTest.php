<?php
namespace VideoStore\Tests\Unit\RentalStatement;

use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;
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

    /** @var  MovieRenter */
    private $movieRenter;

    public function testMultipleRentalStatement()
    {
        $this->statement->addRental($this->movieRenter->rentAMovie($this->newRelease, 1));
        $this->statement->addRental($this->movieRenter->rentAMovie($this->childrens, 2));
        $this->statement->addRental($this->movieRenter->rentAMovie($this->regular, 3));

        $this->assertEquals(8, $this->statement->getAmountOwed(), "Amount owed not do not match");
        $this->assertEquals(3, $this->statement->getFrequentRenterPoints(), "Frequent renter points do not match");
    }

    protected function setUp()
    {
        $this->statement = new RentalStatement("Customer Name");
        $this->newRelease = new Movie("New Release 1", MovieCategory::NewRelease());
        $this->childrens = new Movie("Childrens", MovieCategory::Children());
        $this->regular = new Movie("Regular 3", MovieCategory::Regular());
        $this->movieRenter = new MovieRenter();
    }
}