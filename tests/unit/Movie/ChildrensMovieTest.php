<?php

use VideoStore\Movie\ChildrensMovie;

class ChildrensMovieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \VideoStore\Movie\ChildrensMovie
     */
    private $movie;

    function SetUp()
    {
        $this->movie = new ChildrensMovie("title");
    }

    function testIfRentedLessThanThreeDaysCostIsAlwaysOnePointFive()
    {
        $this->assertEquals(1.5, $this->movie->determineAmount(1));
        $this->assertEquals(1.5, $this->movie->determineAmount(2));
        $this->assertEquals(1.5, $this->movie->determineAmount(3));
    }

    function testIfRentedMoreThanThreeDaysCostIsProportional()
    {
        $this->assertEquals(3, $this->movie->determineAmount(4));
        $this->assertEquals(4.5, $this->movie->determineAmount(5));
    }

    function testFrequentRenterPointsAreAlwaysOne()
    {
        $this->assertEquals(1, $this->movie->determineFrequentRenterPoints(1));
        $this->assertEquals(1, $this->movie->determineFrequentRenterPoints(44));
    }
}