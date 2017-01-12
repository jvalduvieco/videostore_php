<?php

use VideoStore\Movie\NewReleaseMovie;

class NewReleaseMovieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \VideoStore\Movie\NewReleaseMovie
     */
    private $movie;

    function SetUp()
    {
        $this->movie = new NewReleaseMovie("title");
    }

    function testNewReleaseMovieRentingCostsIsProportionalToThree()
    {

        $this->assertEquals(3, $this->movie->determineAmount(1));
        $this->assertEquals(6, $this->movie->determineAmount(2));
    }

    function testFrequentRenterPointsAreOneIfRentedForOneDay()
    {
        $this->assertEquals(1, $this->movie->determineFrequentRenterPoints(1));
    }

    function testFrequentRenterPointsAreTwoIfRentedForMoreThanTwoDays()
    {
        $this->assertEquals(2, $this->movie->determineFrequentRenterPoints(2));
        $this->assertEquals(2, $this->movie->determineFrequentRenterPoints(6));
    }
}