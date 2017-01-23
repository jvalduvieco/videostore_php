<?php
namespace VideoStore\Tests\Unit\Movie;

use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;

class RegularMovieTest extends \PHPUnit_Framework_TestCase
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
        $this->movie = new Movie("title", MovieCategory::Regular());
    }

    function testRentingLessThanTwoDaysAlwaysCostsTwo()
    {
        $this->assertEquals(2, $this->movieRenter->rentAMovie($this->movie, 1)->getRentalAmount());
        $this->assertEquals(2, $this->movieRenter->rentAMovie($this->movie, 2)->getRentalAmount());
    }

    function testRentingMoreThanTwoDays()
    {
        $this->assertEquals(3.5, $this->movieRenter->rentAMovie($this->movie, 3)->getRentalAmount());
    }

    function testFrequentRenterPointsAreAlwaysOne()
    {
        $this->assertEquals(1, $this->movieRenter->rentAMovie($this->movie, 1)->getFrequentRenterPoints());
        $this->assertEquals(1, $this->movieRenter->rentAMovie($this->movie, 3)->getFrequentRenterPoints());
    }
}