<?php
namespace VideoStore\Movie;

use VideoStore\FrequentRenterPointsCalculator\FrequentRenterPointsCalculator;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

abstract class Movie
{
    /**
     * @var FrequentRenterPointsCalculator
     */
    protected $frequentRenterPointsCalculator;
    /**
     * @var RentalPriceCalculator
     */
    protected $priceCalculator;
    private $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getTitle (): string {
        return $this->title;
    }

    public function determineAmount(int $daysRented)
    {
        return $this->priceCalculator->determineRentalAmount($daysRented);
    }

    public function determineFrequentRenterPoints(int $daysRented)
    {
        return $this->frequentRenterPointsCalculator->determineFrequentRenterPoints($daysRented);
    }
}