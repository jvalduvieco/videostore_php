<?php
namespace VideoStore;

use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Facade to use new code on legacy system
 **/
class RentalStatement
{
    /** @var \VideoStore\RentalStatement\RentalStatement */
    private $rentalStatement;

    /** @var \VideoStore\RentalStatement\RentalStatementStringPrinter */
    private $rentalStatementStringPrinter;

    /** @var MovieRenter */
    private $movieRenter;

    /** @var  Rental[] */
    private $rentals;

    /** @var Customer\Customer @var Customer */
    private $customer;

    /**
     * RentalStatement constructor.
     * @param string $customerName
     */
    public function __construct(string $customerName)
    {
        $this->customer = Customer\Customer::findByName($customerName);
        $this->rentalStatement = new RentalStatement\RentalStatement($this->customer);
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
        $this->movieRenter = MovieRenter::createDefaultRenter();
    }

    /**
     * @param Rental $rental
     */
    public function addRental(Rental $rental)
    {
        $this->rentalStatement->addRental(
            $this->movieRenter->rentAMovie($rental->getMovie()->toNewMovie(), $rental->getDaysRented())
        );
        $this->rentals[] = $rental;
    }

    /**
     * @return float
     */
    public function getAmountOwed()
    {
        return $this->rentalStatement->getAmountOwed();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->rentalStatement->getName();
    }

    /**
     * @return int
     */
    public function getFrequentRenterPoints(): int
    {
        return $this->rentalStatement->getFrequentRenterPoints();
    }

    /**
     * @return Rental[]
     */
    public function getRentals()
    {
        return $this->rentals;
    }

    /**
     * @return string
     */
    public function makeRentalStatement()
    {
        return $this->rentalStatementStringPrinter->makeRentalStatement($this->rentalStatement);
    }
}
