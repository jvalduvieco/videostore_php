<?php
namespace VideoStore\Movie;

class NewReleaseMovie extends Movie {
    public function __constructor(string $title) {
        parent::__construct($title);
    }

    public function determineAmount(int $daysRented) {
        return $daysRented * 3.0;
    }

    public function determineFrequentRenterPoints(int $daysRented): int  {
        return ($daysRented > 1) ? 2 : 1;
    }
}
