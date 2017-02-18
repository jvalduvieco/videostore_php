<?php
namespace VideoStore;

use VideoStore\MovieRental\MovieRenter;
use VideoStore\RentalStatement\RentalStatement;
use VideoStore\RentalStatement\RentalStatementStringPrinter;

/**
 * @deprecated
 * Facade to use new code on legacy system
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

    /**
     * Customer constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->customer = new Customer\Customer($name);
        $this->rentalStatement = new RentalStatement($this->customer);
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
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->customer->getName();
    }

    /**
     * @return string
     */
    public function statement(): string
    {
        return $this->rentalStatementStringPrinter->makeRentalStatement($this->rentalStatement);
    }
}
