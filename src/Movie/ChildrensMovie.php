<?php
namespace VideoStore\Movie;

use VideoStore\FrequentRenterPointsCalculator\Fixed;
use VideoStore\RentalPriceCalculator\FixedForNDaysProportionalLater;

class ChildrensMovie extends Movie
{
    public function __construct(string $title)
    {
        $this->priceCalculator = new FixedForNDaysProportionalLater(1.5, 3, 1.5);
        $this->frequentRenterPointsCalculator = new Fixed(1);
        parent::__construct($title);
    }
}