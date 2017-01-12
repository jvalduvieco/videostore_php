<?php
/**
 * Created by PhpStorm.
 * User: joan.valduvieco
 * Date: 12/1/17
 * Time: 15:33
 */

namespace VideoStore\FrequentRenterPointsCalculator;


interface FrequentRenterPointsCalculator
{
    public function determineFrequentRenterPoints(int $days);
}