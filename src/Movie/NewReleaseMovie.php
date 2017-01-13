<?php
namespace VideoStore\Movie;

use VideoStore\FrequentRenterPointsCalculator\FixedForNDaysFixedLater;
use VideoStore\RentalPriceCalculator\Proportional;

class NewReleaseMovie extends Movie {
    public function __construct(string $title)
    {
        $this->priceCalculator = new Proportional(3);
        $this->frequentRenterPointsCalculator = new FixedForNDaysFixedLater(1, 1, 2);
        parent::__construct($title);
    }
}
