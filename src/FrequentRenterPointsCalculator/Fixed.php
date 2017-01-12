<?php

namespace VideoStore\FrequentRenterPointsCalculator;


class Fixed implements FrequentRenterPointsCalculator
{
    private $frequentRenterPoints;

    public function __construct(int $frequentRenterPoints)
    {
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    public function determineFrequentRenterPoints(int $days)
    {
        return $this->frequentRenterPoints;
    }
}