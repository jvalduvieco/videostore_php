<?php
namespace VideoStore\RentalStatement;

use VideoStore\MovieRental\MovieRental;

class RentalStatement
{
    /** @var string */
    private $name;
    /** @var MovieRental[] */
    private $rentals = array();
    /** @var float */
    private $amount = 0;
    /** @var float */
    private $frequentRenterPoints = 0;

    /**
     * RentalStatement constructor.
     * @param string $customerName
     */
    public function __construct(string $customerName)
    {
        $this->name = $customerName;
    }

    /**
     * @param MovieRental $rental
     */
    public function addRental(MovieRental $rental)
    {
        $this->rentals[] = $rental;
        $this->amount += $rental->getRentalAmount();
        $this->frequentRenterPoints += $rental->getFrequentRenterPoints();
    }

    /**
     * @return float
     */
    public function getAmountOwed()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getFrequentRenterPoints(): int
    {
        return $this->frequentRenterPoints;
    }

    /**
     * @return MovieRental[]
     */
    public function getRentals()
    {
        return $this->rentals;
    }

    /**
     * @deprecated
     */
    public function makeRentalStatement()
    {
        $formatter = new RentalStatementStringPrinter();
        return $formatter->makeRentalStatement($this);
    }
}