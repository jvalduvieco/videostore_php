<?php
namespace VideoStore\Tests\Unit\Customer;

use VideoStore\Customer\Customer;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    function SetUp()
    {
        $this->customer = new Customer("Customer Name");
    }

    public function testICanReadTheCustomerName()
    {
        $this->assertEquals("Customer Name", $this->customer->getName());
    }
}