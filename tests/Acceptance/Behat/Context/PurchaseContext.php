<?php
namespace VideoStore\Tests\Acceptance\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class PurchaseContext implements Context
{
    /**
     * @Given /^I sign up as giving my name "([^"]*)"$/
     */
    public function iSignUpAsGivingMyName($userName)
    {
        throw new PendingException();
    }

    /**
     * @Given then I rent the following movies
     * @param TableNode $table
     */
    public function thenIRentTheFollowingMovies(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When I request my rental statement
     */
    public function iRequestMyRentalStatement()
    {
        throw new PendingException();
    }

    /**
     * @Then I shoud see the next report
     * @param PyStringNode $string
     */
    public function iShoudSeeTheNextReport(PyStringNode $string)
    {
        throw new PendingException();
    }

    /**
     * @Given The following strategies to calculate frequent renter points and rental amount are present in the catalog:
     * @param TableNode $table
     */
    public function theFollowingStrategiesToCalculateFrequentRenterPointsAndRentalAmountArePresentInTheCatalog(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given the following strategies to calculate rental amount:
     * @param TableNode $table
     */
    public function theFollowingStrategiesToCalculateRentalAmount(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given the following movies are in the videostore catalog:
     * @param TableNode $table
     */
    public function theFollowingMoviesAreInTheVideostoreCatalog(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When I rent the following movies
     * @param TableNode $table
     */
    public function iRentTheFollowingMovies(TableNode $table)
    {
        throw new PendingException();
    }
}