<?php
namespace VideoStore\RentalPriceCalculator;


class Proportional implements RentalPriceCalculator
{
    private $pricePerDay;

    function __construct($pricePerDay)
    {
        $this->pricePerDay = $pricePerDay;
    }

    public function determineRentalAmount(int $days)
    {
        return $this->pricePerDay * $days;
    }
}