<?php
namespace VideoStore\Movie;

use InvalidArgumentException;
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
        if (is_null($this->priceCalculator)) throw new InvalidArgumentException("Movie Must have a PriceCalculator");
        if (is_null($this->frequentRenterPointsCalculator))
            throw new InvalidArgumentException("Movie Must have a FrequentRentalPointsCalculator");
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