<?php

namespace VideoStore\FrequentRenterPointsCalculator;


class Fixed implements FrequentRenterPointsCalculator
{
    /** @var float */
    private $frequentRenterPoints;

    public function __construct(float $frequentRenterPoints)
    {
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    public function determineFrequentRenterPoints(int $days)
    {
        return $this->frequentRenterPoints;
    }
}