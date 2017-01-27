<?php

namespace VideoStore;

use VideoStore\Movie\MovieCategory;
use VideoStore\MovieRental\MovieRenter;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
abstract class Movie
{
    /** @var  \VideoStore\Movie\Movie */
    private $movie;

    /** @var MovieRenter */
    private $movieRenter;

    protected function __construct(string $title, MovieCategory $category)
    {
        $this->movie = new Movie\Movie($title, $category);
        $this->movieRenter = MovieRenter::createDefaultRenter();
    }

    public function getTitle(): string
    {
        return $this->movie->getTitle();
    }

    public function getCategory(): MovieCategory
    {
        return $this->movie->getCategory();
    }

    /**
     * @return Movie\Movie
     */
    public function toNewMovie(): Movie\Movie
    {
        return $this->movie;
    }

    public function determineAmount(int $daysRented)
    {
        return $this->movieRenter->rentAMovie($this->movie, $daysRented)->getRentalAmount();
    }

    public function determineFrequentRenterPoints(int $daysRented)
    {
        return $this->movieRenter->rentAMovie($this->movie, $daysRented)->getFrequentRenterPoints();
    }
}