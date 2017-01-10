<?php

namespace VideoStore;


use VideoStore\Movie\RegularMovie;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    public function testICanGetTheCustomerName()
    {
        $this->assertEquals("Customer Name", $this->customer->getName());
    }

    public function testICanCreateARentalStatement()
    {
        $this->customer->addRental(new Rental(new RegularMovie("Regular 2"), 3));
        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tRegular 2\t3.5\n" .
            "You owed 3.5\n" .
            "You earned 1 frequent renter points\n"
            , $this->customer->statement());
    }

    protected function setUp()
    {
        $this->customer = new Customer("Customer Name");
    }
}