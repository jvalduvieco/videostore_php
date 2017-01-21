<?php
namespace VideoStore;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
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

    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    public function determineAmount() {
        throw new \Exception("Deprecated");
    }

    public function determineFrequentRenterPoints(): int  {
        throw new \Exception("Deprecated");
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

}