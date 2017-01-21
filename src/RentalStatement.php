<?php
namespace VideoStore;

use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class RentalStatement {
    /** @var \VideoStore\RentalStatement\RentalStatement */
    private $rentalStatement;

    /** @var \VideoStore\RentalStatement\RentalStatementStringPrinter */
    private $rentalStatementStringPrinter;

    /** @var MovieRenter */
    private $movieRenter;

    /** @var  Rental[] */
    private $rentals;

    public function __construct(string $customerName)
    {
        $this->rentalStatement = new RentalStatement\RentalStatement($customerName);
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
        $this->movieRenter = new MovieRenter();
    }

    public function addRental(Rental $rental)
    {
        $this->rentalStatement->addRental(
            $this->movieRenter->rentAMovie($rental->getMovie()->toNewMovie(), $rental->getDaysRented())
        );
        $this->rentals[] = $rental;
    }

    public function getAmountOwed()
    {
        return $this->rentalStatement->getAmountOwed();
    }

    public function getName(): string
    {
        return $this->rentalStatement->getName();
    }

    public function getFrequentRenterPoints(): int
    {
        return $this->rentalStatement->getFrequentRenterPoints();
    }

    /**
     * @return Rental[]
     */
    public function getRentals()
    {
        //return $this->rentalStatement->getRentals();
        return $this->rentals;
    }

    public function makeRentalStatement()
    {
        return $this->rentalStatementStringPrinter->makeRentalStatement($this->rentalStatement);
    }
}