<?php
namespace VideoStore\Movie;

use VideoStore\FrequentRenterPointsCalculator\FixedForNDaysFixedLater;
use VideoStore\RentalPriceCalculator\Proportional;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

class NewReleaseMovie extends Movie {
    /**
     * @var RentalPriceCalculator
     */
    private $priceCalculator;
    private $frequentRenterPointsCalculator;

    public function __construct(string $title)
    {
        $this->priceCalculator = new Proportional(3);
        $this->frequentRenterPointsCalculator = new FixedForNDaysFixedLater(1, 1, 2);
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented) {
        return $this->priceCalculator->determineRentalAmount($daysRented);
    }

    public function determineFrequentRenterPoints(int $daysRented): int  {
        return $this->frequentRenterPointsCalculator->determineFrequentRenterPoints($daysRented);
    }
}
