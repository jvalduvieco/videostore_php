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
    private $amount;
    private $frequentRenterPoints;

    public function __construct(string $customerName) {
        $this->name = $customerName;
    }

    public function addRental(Rental $rental) {
        $this->rentals[] = $rental;
        $this->amount += $rental->determineAmount();
        $this->frequentRenterPoints += $rental->determineFrequentRenterPoints();
    }

    public function getAmountOwed() {
        return $this->amount;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFrequentRenterPoints(): int {
        return $this->frequentRenterPoints;
    }

    public function makeRentalStatement(): string {
        return $this->makeHeader() . $this->makeRentalLines() . $this->makeSummary();
    }

    private function makeHeader(): string  {
        return "Rental Record for " . $this->getName() . "\n";
    }

    private function makeRentalLines(): string {
        $rentalLines = "";

        foreach ($this->rentals as $rental)
            $rentalLines .= $this->makeRentalLine($rental);

        return $rentalLines;
    }

    private function makeRentalLine(Rental $rental): string  {
        return $this->formatRentalLine($rental, $rental->determineAmount());
    }

    private function  formatRentalLine(Rental $rental, $thisAmount): string {
        return "\t" . $rental->getTitle() . "\t" . number_format((float)$thisAmount, 1, '.', '') . "\n";
    }

    private function makeSummary(): string {
        return "You owed " . $this->amount . "\n"
        ."You earned " . $this->frequentRenterPoints . " frequent renter points\n";
    }
}