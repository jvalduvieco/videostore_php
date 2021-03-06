<?php
namespace VideoStore\RentalPriceCalculator;

class Proportional implements RentalPriceCalculator
{
    /** @var  float */
    private $pricePerDay;

    public function __construct(float $pricePerDay)
    {
        $this->pricePerDay = $pricePerDay;
    }

    public function determineRentalAmount(int $days)
    {
        return $this->pricePerDay * $days;
    }
}
