<?php
namespace VideoStore\Movie;

abstract class Movie
{
    private $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getTitle (): string {
		return $this->title;
	}

  public abstract function determineAmount(int $daysRented);

  public abstract function determineFrequentRenterPoints(int $daysRented): int;
}