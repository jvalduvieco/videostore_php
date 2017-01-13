<?php

use VideoStore\FrequentRenterPointsCalculator\Fixed;
use VideoStore\Movie\Movie;
use VideoStore\RentalPriceCalculator\Proportional;

class AMovieWithoutPriceCalculator extends Movie
{
    function __construct($title)
    {
        $this->frequentRenterPointsCalculator = new Fixed(1);
        parent::__construct($title);
    }
}

class AMovieWithoutFrequentRenterPointsCalculator extends Movie
{
    function __construct($title)
    {
        $this->priceCalculator = new Proportional(1);
        parent::__construct($title);
    }
}

class MovieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    function testICanNotCreateAMovieWithoutAPriceCalculator()
    {
        new AMovieWithoutPriceCalculator("This should throw an exception");

    }

    /**
     * @expectedException InvalidArgumentException
     */
    function testICanNotCreateAMovieWithoutAFrequentRenterPointsCalculator()
    {
        new AMovieWithoutFrequentRenterPointsCalculator("This should throw an exception");

    }

}