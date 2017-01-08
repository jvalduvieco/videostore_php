<?php
namespace VideoStore\RentalStatement;

use VideoStore\Rental;

class RentalStatement
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Rental[]
     */
    private $rentals = array();
    private $amount = 0;
    private $frequentRenterPoints = 0;

    public function __construct(string $customerName)
    {
        $this->name = $customerName;
    }

    public function addRental(Rental $rental)
    {
        $this->rentals[] = $rental;
        $this->amount += $rental->determineAmount();
        $this->frequentRenterPoints += $rental->determineFrequentRenterPoints();
    }

    public function getAmountOwed()
    {
        return $this->amount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFrequentRenterPoints(): int
    {
        return $this->frequentRenterPoints;
    }

    /**
     * @return Rental[]
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