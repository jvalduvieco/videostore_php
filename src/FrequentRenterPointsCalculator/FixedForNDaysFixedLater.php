<?php
/**
 * Created by PhpStorm.
 * User: joan.valduvieco
 * Date: 12/1/17
 * Time: 15:38
 */

namespace VideoStore\FrequentRenterPointsCalculator;


class FixedForNDaysFixedLater implements FrequentRenterPointsCalculator
{

    private $secondFixedPoints;
    private $daysAtFirstPoints;
    private $firstFixedPoints;

    public function __construct($firstFixedPoints, $daysAtFirstPoints, $secondFixedPoints)
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