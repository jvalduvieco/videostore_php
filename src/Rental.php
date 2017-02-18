<?php
namespace VideoStore;

/**
 * @deprecated
 * Facade to use new code on legacy system
 **/
class Rental
{
    /** @var Movie */
    private $movie;
    /** @var int  */
    private $daysRented;

    /**
     * Rental constructor.
     * @param Movie $movie
     * @param int $daysRented
     */
    public function __construct(Movie $movie, int $daysRented)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->movie->getTitle();
    }

    /**
     * @return int
     */
    public function getDaysRented(): int
    {
        return $this->daysRented;
    }

    /**
     * @throws \Exception
     */
    public function determineAmount()
    {
        throw new \Exception("Deprecated");
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function determineFrequentRenterPoints(): int
    {
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
