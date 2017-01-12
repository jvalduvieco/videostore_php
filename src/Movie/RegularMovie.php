<?php
namespace VideoStore\Movie;

use VideoStore\RentalPriceCalculator\FixedForNDaysProportionalLater;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

class RegularMovie extends Movie {
    /**
     * @var RentalPriceCalculator
     */
    private $priceCalculator;

    public function __construct(string $title)
    {
        $this->priceCalculator = new FixedForNDaysProportionalLater(2, 2, 1.5);
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented)  {
        return $this->priceCalculator->determineRentalAmount($daysRented);
    }

    public function determineFrequentRenterPoints(int $daysRented): int {
        return 1;
    }
}
