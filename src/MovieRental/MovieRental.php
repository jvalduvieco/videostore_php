<?php
namespace VideoStore\MovieRental;

use VideoStore\Movie\Movie;

class MovieRental
{
    /** @var Movie */
    private $movie;

    /** @var int */
    private $daysRented;

    /** @var float */
    private $amount;

    /** @var float */
    private $frequentRenterPoints;

    /**
     * MovieRental constructor.
     * @param Movie $movie
     * @param int $daysRented
     * @param float $amount
     * @param float $frequentRenterPoints
     */
    public function __construct(Movie $movie, int $daysRented, float $amount, float $frequentRenterPoints)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
        $this->amount = $amount;
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    /** @return Movie */
    public function getMovie()
    {
        return $this->movie;
    }

    /** @return int */
    public function getDaysRented()
    {
        return $this->daysRented;
    }

    /** @return float */
    public function getRentalAmount()
    {
        return $this->amount;
    }

    /** @return float */
    public function getFrequentRenterPoints()
    {
        return $this->frequentRenterPoints;
    }
}
