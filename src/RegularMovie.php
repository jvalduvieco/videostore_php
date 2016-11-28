<?php
namespace VideoStore;

 class RegularMovie extends Movie {
    public function __constructor(string $title) {
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented)  {
        $thisAmount = 2;
        if ($daysRented > 2)
            $thisAmount += ($daysRented - 2) * 1.5;

        return $thisAmount;
    }

    public function determineFrequentRenterPoints(int $daysRented): int {
        return 1;
    }
}
