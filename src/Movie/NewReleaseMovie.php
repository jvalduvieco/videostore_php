<?php
namespace VideoStore\Movie;

use VideoStore\RentalPriceCalculator\Proportional;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

class NewReleaseMovie extends Movie {
    /**
     * @var RentalPriceCalculator
     */
    private $priceCalculator;

    public function __constructor(string $title) {
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented) {
        $this->priceCalculator = new Proportional(3);
        return $this->priceCalculator->determineRentalAmount($daysRented);
    }

    public function determineFrequentRenterPoints(int $daysRented): int  {
        return ($daysRented > 1) ? 2 : 1;
    }
}
