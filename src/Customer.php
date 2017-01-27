<?php
namespace VideoStore;

use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class Customer
{
    /** @var Customer\Customer */
    private $customer;
    /** @var \VideoStore\RentalStatement\RentalStatement */
    private $rentalStatement;

    /** @var \VideoStore\RentalStatement\RentalStatementStringPrinter */
    private $rentalStatementStringPrinter;

    /** @var MovieRenter */
    private $movieRenter;

    public function __construct(string $name)
    {
        $this->customer = new Customer\Customer($name);
        $this->rentalStatement = new RentalStatement($this->customer);
        $this->rentalStatementStringPrinter = new RentalStatementStringPrinter();
        $this->movieRenter = MovieRenter::createDefaultRenter();
    }

    public function addRental(Rental $rental)
    {
        $this->rentalStatement->addRental(
            $this->movieRenter->rentAMovie($rental->getMovie()->toNewMovie(), $rental->getDaysRented())
        );
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
