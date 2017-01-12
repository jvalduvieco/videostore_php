<?php
namespace VideoStore\Movie;

use VideoStore\FrequentRenterPointsCalculator\Fixed;
use VideoStore\RentalPriceCalculator\FixedForNDaysProportionalLater;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

class ChildrensMovie extends Movie
{
    /**
     * @var RentalPriceCalculator
     */
    private $priceCalculator;
    private $frequentRenterPointsCalculator;

    public function __construct(string $title)
    {
        $this->priceCalculator = new FixedForNDaysProportionalLater(1.5, 3, 1.5);
        $this->frequentRenterPointsCalculator = new Fixed(1);
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented)
    {
        return $this->priceCalculator->determineRentalAmount($daysRented);
    }

    public function determineFrequentRenterPoints(int $daysRented): int
    {
        return $this->frequentRenterPointsCalculator->determineFrequentRenterPoints($daysRented);
    }
}