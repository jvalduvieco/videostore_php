<?php
namespace VideoStore\RentalPriceCalculator;

class FixedForNDaysProportionalLater implements RentalPriceCalculator
{
    /** @var  float */
    private $fixedPrice;
    /** @var  float */
    private $pricePerDay;
    /** @var int */
    private $daysInFixedPrice;

    /**
     * FixedForNDaysProportionalLater constructor.
     * @param $fixedPrice
     * @param int $daysInFixedPrice
     * @param $pricePerDay
     */
    public function __construct($fixedPrice, int $daysInFixedPrice, $pricePerDay)
    {
        $this->fixedPrice = $fixedPrice;
        $this->daysInFixedPrice = $daysInFixedPrice;
        $this->pricePerDay = $pricePerDay;
    }

    /**
     * @param int $daysRented
     * @return int
     */
    public function determineRentalAmount(int $daysRented)
    {
        $rentalAmount = $this->fixedPrice;
        if ($daysRented > $this->daysInFixedPrice) {
            $rentalAmount += ($daysRented - $this->daysInFixedPrice) * $this->pricePerDay;
        }

        return $rentalAmount;
    }
}
