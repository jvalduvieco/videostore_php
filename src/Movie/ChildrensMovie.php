<?php
namespace VideoStore\Movie;

class ChildrensMovie extends Movie
{
    public function __constructor(string $title)
    {
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented)
    {
        $thisAmount = 1.5;
        if ($daysRented > 3)
            $thisAmount += ($daysRented - 3) * 1.5;

        return $thisAmount;
    }

    public function determineFrequentRenterPoints(int $daysRented): int
    {
        return 1;
    }
}