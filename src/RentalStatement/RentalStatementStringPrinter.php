<?php
namespace VideoStore\RentalStatement;

use VideoStore\MovieRental\MovieRental;

class RentalStatementStringPrinter
{
    public function makeRentalStatement(RentalStatement $rentalStatement): string
    {
        return
            $this->makeHeader($rentalStatement) .
            $this->makeRentalLines($rentalStatement) .
            $this->makeSummary($rentalStatement);
    }

    private function makeHeader(RentalStatement $rentalStatement): string
    {
        return "Rental Record for " . $rentalStatement->getName() . "\n";
    }

    private function makeRentalLines(RentalStatement $rentalStatement): string
    {
        $rentalLines = "";

        foreach ($rentalStatement->getrentals() as $rental)
            $rentalLines .= $this->makeRentalLine($rental);

        return $rentalLines;
    }


    private function makeRentalLine(MovieRental $rental): string
    {
        return "\t" . $rental->getMovie()->getTitle() . "\t" . number_format((float)$rental->getRentalAmount(), 1, '.', '') . "\n";
    }

    private function makeSummary(RentalStatement $rentalStatement): string
    {
        return "You owed " . $rentalStatement->getAmountOwed() . "\n"
            . "You earned " . $rentalStatement->getFrequentRenterPoints() . " frequent renter points\n";
    }
}