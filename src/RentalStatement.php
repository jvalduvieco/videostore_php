<?php
namespace VideoStore;

class RentalStatement {
    /**
     * @var string
     */
    private $name;
    /**
     * @var Rental[]
     */
    private $rentals = array();
    private $totalAmount;
    private $frequentRenterPoints;

    public function __construct(string $customerName) {
        $this->name = $customerName;
    }

    public function addRental(Rental $rental) {
        $this->rentals[] = $rental;
    }

    public function makeRentalStatement(): string {
        $this->clearTotals();
        return $this->makeHeader() . $this->makeRentalLines() . $this->makeSummary();
    }

    private function clearTotals() {
        $this->totalAmount = 0;
        $this->frequentRenterPoints = 0;
    }

    private function makeHeader(): string  {
        return "Rental Record for " . $this->getName() . "\n";
    }

    public function getName(): string {
        return $this->name;
    }

    private function makeRentalLines(): string {
        $rentalLines = "";

        foreach ($this->rentals as $rental)
            $rentalLines .= $this->makeRentalLine($rental);

        return $rentalLines;
    }

    private function makeRentalLine(Rental $rental): string  {
        $thisAmount = $rental->determineAmount();
        $this->frequentRenterPoints += $rental->determineFrequentRenterPoints();
        $this->totalAmount += $thisAmount;

        return $this->formatRentalLine($rental, $thisAmount);
    }

    private function  formatRentalLine(Rental $rental, $thisAmount): string {
        return "\t" . $rental->getTitle() . "\t" . number_format((float)$thisAmount, 1, '.', '') . "\n";
    }

    private function makeSummary(): string {
        return "You owed " . $this->totalAmount . "\n"
        ."You earned " . $this->frequentRenterPoints . " frequent renter points\n";
    }

    public function getAmountOwed() {
        return $this->totalAmount;
    }

    public function getFrequentRenterPoints(): int {
        return $this->frequentRenterPoints;
    }
}