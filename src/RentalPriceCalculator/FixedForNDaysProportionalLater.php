<?php
namespace VideoStore\RentalPriceCalculator;


class FixedForNDaysProportionalLater implements RentalPriceCalculator
{
    private $fixedPrice;
    private $pricePerDay;
    private $daysInFixedPrice;

    function __construct($fixedPrice, int $daysInFixedPrice, $pricePerDay)
    {
        $this->fixedPrice = $fixedPrice;
        $this->daysInFixedPrice = $daysInFixedPrice;
        $this->pricePerDay = $pricePerDay;
    }

    public function determineRentalAmount(int $daysRented)
    {
        $rentalAmount = $this->fixedPrice;
        if ($daysRented > $this->daysInFixedPrice)
            $rentalAmount += ($daysRented - $this->daysInFixedPrice) * $this->pricePerDay;

        return $rentalAmount;
    }
}