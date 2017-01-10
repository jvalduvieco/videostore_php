<?php

use VideoStore\Movie\RegularMovie;

class RegularMovieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \VideoStore\Movie\Movie
     */
    private $movie;

    function SetUp()
    {
        $this->movie = new RegularMovie("title");
    }

    function testRentingLessThanTwoDaysAlwaysCostsTwo()
    {
        $this->assertEquals(2, $this->movie->determineAmount(1));
        $this->assertEquals(2, $this->movie->determineAmount(2));
    }

    function testRentingMoreThanTwoDays()
    {
        $this->assertEquals(3.5, $this->movie->determineAmount(3));
    }

    function testFrequentRenterPointsAreAlwaysOne()
    {
        $this->assertEquals(1, $this->movie->determineFrequentRenterPoints(1));
        $this->assertEquals(1, $this->movie->determineFrequentRenterPoints(3));
    }
}