<?php
namespace VideoStore\Tests\Unit\Movie;

use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;

class ChildrensMovieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \VideoStore\Movie\Movie
     */
    private $movie;

    /**
     * @var \VideoStore\MovieRental\MovieRenter
     */
    private $movieRenter;

    function SetUp()
    {
        $this->movieRenter = MovieRenter::createDefaultRenter();
        $this->movie = new Movie("title", MovieCategory::children());
    }

    function testIfRentedLessThanThreeDaysCostIsAlwaysOnePointFive()
    {
        $this->assertEquals(1.5, $this->movieRenter->rentAMovie($this->movie, 1)->getRentalAmount());
        $this->assertEquals(1.5, $this->movieRenter->rentAMovie($this->movie, 2)->getRentalAmount());
        $this->assertEquals(1.5, $this->movieRenter->rentAMovie($this->movie, 3)->getRentalAmount());
    }

    function testIfRentedMoreThanThreeDaysCostIsProportional()
    {
        $this->assertEquals(3, $this->movieRenter->rentAMovie($this->movie, 4)->getRentalAmount());
        $this->assertEquals(4.5, $this->movieRenter->rentAMovie($this->movie, 5)->getRentalAmount());
    }

    function testFrequentRenterPointsAreAlwaysOne()
    {
        $this->assertEquals(1, $this->movieRenter->rentAMovie($this->movie, 1)->getFrequentRenterPoints());
        $this->assertEquals(1, $this->movieRenter->rentAMovie($this->movie, 44)->getFrequentRenterPoints());
    }
}