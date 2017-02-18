<?php

namespace VideoStore\FrequentRenterPointsCalculator;

class FixedForNDaysFixedLater implements FrequentRenterPointsCalculator
{
    /** @var  float */
    private $secondFixedPoints;
    /** @var  int */
    private $daysAtFirstPoints;
    /** @var  float */
    private $firstFixedPoints;

    public function __construct(float $firstFixedPoints, int $daysAtFirstPoints, float $secondFixedPoints)
    {
        $this->firstFixedPoints = $firstFixedPoints;
        $this->daysAtFirstPoints = $daysAtFirstPoints;
        $this->secondFixedPoints = $secondFixedPoints;
    }

    public function determineFrequentRenterPoints(int $days)
    {
        return ($days > $this->daysAtFirstPoints) ? $this->secondFixedPoints : $this->firstFixedPoints;
    }
}
