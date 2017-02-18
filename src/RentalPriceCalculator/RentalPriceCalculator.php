<?php

namespace VideoStore\RentalPriceCalculator;

interface RentalPriceCalculator
{
    public function determineRentalAmount(int $days);
}
