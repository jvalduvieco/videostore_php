<?php
namespace VideoStore\Tests\Unit\Movie;

use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;

class NewReleaseMovieTest extends \PHPUnit_Framework_TestCase
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
        $this->movie = new Movie("title", MovieCategory::newRelease());
        $this->movieRenter = MovieRenter::createDefaultRenter();
    }

    function testNewReleaseMovieRentingCostsIsProportionalToThree()
    {
        $this->assertEquals(3, $this->movieRenter->rentAMovie($this->movie, 1)->getRentalAmount());
        $this->assertEquals(6, $this->movieRenter->rentAMovie($this->movie, 2)->getRentalAmount());
    }

    function testFrequentRenterPointsAreOneIfRentedForOneDay()
    {
        $this->assertEquals(1, $this->movieRenter->rentAMovie($this->movie, 1)->getFrequentRenterPoints());
    }

    function testFrequentRenterPointsAreTwoIfRentedForMoreThanTwoDays()
    {
        $this->assertEquals(2, $this->movieRenter->rentAMovie($this->movie, 2)->getFrequentRenterPoints());
        $this->assertEquals(2, $this->movieRenter->rentAMovie($this->movie, 6)->getFrequentRenterPoints());
    }
}