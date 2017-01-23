<?php
namespace VideoStore\Tests\Unit\RentalPriceCalculator;

use VideoStore\RentalPriceCalculator\FixedForNDaysProportionalLater;

class FixedForNDaysProportionalLaterTest extends \PHPUnit_Framework_TestCase
{
    function testPriceForFixedDaysIsConstant()
    {
        $priceCalculator = new FixedForNDaysProportionalLater(3, 2, 5);
        $this->assertEquals(3, $priceCalculator->determineRentalAmount(1));
        $this->assertEquals(3, $priceCalculator->determineRentalAmount(2));
    }

    function testPriceIsProportionalAfterFixedDays()
    {
        $priceCalculator = new FixedForNDaysProportionalLater(3, 2, 5);
        $this->assertEquals(8, $priceCalculator->determineRentalAmount(3));
        $this->assertEquals(13, $priceCalculator->determineRentalAmount(4));
    }
}