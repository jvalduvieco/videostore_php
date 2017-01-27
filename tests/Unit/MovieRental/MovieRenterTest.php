<?php


namespace VideoStore\Tests\Unit\MovieRental;


use VideoStore\FrequentRenterPointsCalculator\Fixed;
use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalPriceCalculator\Proportional;

class MovieRenterTest extends \PHPUnit_Framework_TestCase
{
    public function testICanRentAMovie()
    {
        $movie = new Movie("A Movie", MovieCategory::Regular());
        $defaultAmountStrategies = array(
            MovieCategory::REGULAR => new Proportional(24)
        );
        $defaultFrequentRenterPointsStrategies = array(
            MovieCategory::REGULAR => new Fixed(15443)
        );
        $renter = new MovieRenter($defaultAmountStrategies, $defaultFrequentRenterPointsStrategies);

        $rental = $renter->rentAMovie($movie, 23);
        $this->assertEquals(552, $rental->getRentalAmount());
        $this->assertEquals(15443, $rental->getFrequentRenterPoints());
    }
}
