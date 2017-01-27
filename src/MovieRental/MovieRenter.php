<?php
namespace VideoStore\MovieRental;

use Exception;
use VideoStore\FrequentRenterPointsCalculator\Fixed;
use VideoStore\FrequentRenterPointsCalculator\FixedForNDaysFixedLater;
use VideoStore\FrequentRenterPointsCalculator\FrequentRenterPointsCalculator;
use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;
use VideoStore\RentalPriceCalculator\FixedForNDaysProportionalLater;
use VideoStore\RentalPriceCalculator\Proportional;
use VideoStore\RentalPriceCalculator\RentalPriceCalculator;

class MovieRenter
{
    /** @var RentalPriceCalculator[] */
    private $calculateAmountStrategies;

    /** @var FrequentRenterPointsCalculator[] */
    private $calculateFrequentRenterPointsStrategies;


    public function __construct($calculateAmountSetup, $calculateFrequentRenterPointsSetup)
    {
        $this->calculateAmountStrategies = $calculateAmountSetup;
        $this->calculateFrequentRenterPointsStrategies = $calculateFrequentRenterPointsSetup;
    }

    public static function createDefaultRenter()
    {
        $defaultAmountStrategies = array(
            MovieCategory::CHILDREN => new FixedForNDaysProportionalLater(1.5, 3, 1.5),
            MovieCategory::NEW_RELEASE => new Proportional(3),
            MovieCategory::REGULAR => new FixedForNDaysProportionalLater(2, 2, 1.5)
        );
        $defaultFrequentRenterPointsStrategies = array(
            MovieCategory::CHILDREN => new Fixed(1),
            MovieCategory::NEW_RELEASE => new FixedForNDaysFixedLater(1, 1, 2),
            MovieCategory::REGULAR => new Fixed(1)
        );

        return new self($defaultAmountStrategies, $defaultFrequentRenterPointsStrategies);
    }
    /**
     * @param Movie $movie
     * @param int $daysRented
     * @return MovieRental
     */
    public function rentAMovie(Movie $movie, int $daysRented): MovieRental
    {
        $amount = $this->calculateRentalAmount($movie, $daysRented);
        $frequentRenterPoints = $this->calculateFrequentRenterPoints($movie, $daysRented);

        return new MovieRental($movie, $daysRented, $amount, $frequentRenterPoints);
    }

    /**
     * @param Movie $movie
     * @param int $daysRented
     * @return float
     * @throws CanNotCalculateRentalAmount
     */
    private function calculateRentalAmount(Movie $movie, int $daysRented): float
    {
        if (!isset($this->calculateAmountStrategies[$movie->getCategory()->getId()])) {
            throw new CanNotCalculateRentalAmount();
        }

        return
            $this
                ->calculateAmountStrategies[$movie->getCategory()->getId()]
                ->determineRentalAmount($daysRented);
    }

    /**
     * @param Movie $movie
     * @param $daysRented
     * @return float
     * @throws CanNotCalculateFrequentRenterPoints
     */
    private function calculateFrequentRenterPoints($movie, $daysRented): float
    {
        if (!isset($this->calculateFrequentRenterPointsStrategies[$movie->getCategory()->getId()])) {
            throw new CanNotCalculateFrequentRenterPoints();
        }

        return
            $this
                ->calculateFrequentRenterPointsStrategies[$movie->getCategory()->getId()]
                ->determineFrequentRenterPoints($daysRented);
    }
}

class CanNotCalculateRentalAmount extends Exception
{
}

class CanNotCalculateFrequentRenterPoints extends Exception
{
}
