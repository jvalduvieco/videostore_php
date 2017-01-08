<?php
namespace VideoStore;

use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class Customer
{
    /**
     * @var \VideoStore\Customer
     */
    private $customer;
    /**
     * @var \VideoStore\RentalStatement\RentalStatement
     */
    private $rentalStatement;

    /**
     * @var \VideoStore\RentalStatement\RentalStatementStringPrinter
     */
    private $rentalStatementStringPrinter;

    public function __construct(string $name) {
        $this->customer = new Customer\Customer($name);
        $this->rentalStatement = new RentalStatement($name);
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
    }

    public function addRental(Rental $rental)
    {
        $this->rentalStatement->addRental($rental);
    }

    public function getName(): string
    {
        return $this->customer->getName();
    }

    public function statement(): string
    {
        return $this->rentalStatementStringPrinter->makeRentalStatement($this->rentalStatement);
    }
}