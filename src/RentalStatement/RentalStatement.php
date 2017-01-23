<?php
namespace VideoStore\RentalStatement;

use VideoStore\Customer\Customer;
use VideoStore\MovieRental\MovieRental;

class RentalStatement
{
    /** @var Customer */
    private $customer;
    /** @var MovieRental[] */
    private $rentals = array();
    /** @var float */
    private $amount = 0;
    /** @var float */
    private $frequentRenterPoints = 0;

    /**
     * RentalStatement constructor.
     * @param string|Customer $customerName
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
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
        return $this->customer->getName();
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