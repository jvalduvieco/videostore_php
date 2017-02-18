<?php

namespace VideoStore\FrequentRenterPointsCalculator;

interface FrequentRenterPointsCalculator
{
    public function determineFrequentRenterPoints(int $days);
}
