<?php
namespace VideoStore\Tests\Unit\RentalPriceCalculator;

use VideoStore\RentalPriceCalculator\Proportional;

class ProportionalTest extends \PHPUnit_Framework_TestCase
{
    function testPriceIsProportionalToDaysRented()
    {
        $priceCalculator = new Proportional(4);
        $this->assertEquals(8, $priceCalculator->determineRentalAmount(2));
        $this->assertEquals(16, $priceCalculator->determineRentalAmount(4));
    }
}