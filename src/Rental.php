<?php
namespace VideoStore;

class Rental
{
    /**
     * @var Movie
     */
    private $movie;
    private $daysRented;

    public function __construct(Movie $movie, int $daysRented) {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
    }

    public function getTitle(): string {
        return $this->movie->getTitle();
    }

    public function determineAmount() {
        return $this->movie->determineAmount($this->daysRented);
    }

    public function determineFrequentRenterPoints(): int  {
        return $this->movie->determineFrequentRenterPoints($this->daysRented);
  }
}