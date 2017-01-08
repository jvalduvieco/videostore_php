<?php
namespace VideoStore;

use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class RentalStatement {
    /**
     * @var \VideoStore\RentalStatement\RentalStatement
     */
    private $rentalStatement;

    /**
     * @var \VideoStore\RentalStatement\RentalStatementStringPrinter
     */
    private $rentalStatementStringPrinter;

    public function __construct(string $customerName) {
        $this->rentalStatement = new RentalStatement\RentalStatement($customerName);
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();

    }

    public function addRental(Rental $rental) {
        $this->rentalStatement->addRental($rental);
    }

    public function getAmountOwed() {
        return $this->rentalStatement->getAmountOwed();
    }

    public function getName(): string {
        return $this->rentalStatement->getName();
    }

    public function getFrequentRenterPoints(): int {
        return $this->rentalStatement->getFrequentRenterPoints();
    }

    /**
     * @return Rental[]
     */
    public function getRentals()
    {
        return $this->rentalStatement->getRentals();
    }

    public function makeRentalStatement()
    {
        return $this->rentalStatementStringPrinter->makeRentalStatement($this->rentalStatement);
    }
}