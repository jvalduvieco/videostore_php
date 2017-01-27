<?php
/**
 * Created by IntelliJ IDEA.
 * User: jvalduvieco
 * Date: 12/1/17
 * Time: 7:03
 */

namespace VideoStore\RentalPriceCalculator;


interface RentalPriceCalculator
{
    public function determineRentalAmount(int $days);
}