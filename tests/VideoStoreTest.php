<?php
namespace VideoStore;

class VideoStoreTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var RentalStatement
     */
    private $statement;
    /**
     * @var NewReleaseMovie
     */
    private $newRelease1;
    /**
     * @var NewReleaseMovie
     */
    private $newRelease2;
    /**
     * @var ChildrensMovie
     */
    private $childrens;
    /**
     * @var RegularMovie
     */
    private $regular1;
    /**
     * @var RegularMovie
     */
    private $regular2;
    /**
     * @var RegularMovie
     */
    private $regular3;

    public function testSingleNewReleaseStatement()
    {
        $this->statement->addRental(new Rental($this->newRelease1, 3));
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(9.0, 2);
    }

    private function assertAmountAndPointsForReport(float $expectedAmount, int $expectedPoints)
    {
        $this->assertEquals($expectedAmount, $this->statement->getAmountOwed(), "Amount owed not do not match");
        $this->assertEquals($expectedPoints, $this->statement->getFrequentRenterPoints(), "Frequent renter points do not match");
    }

    public function testDualNewReleaseStatement()
    {
        $this->statement->addRental(new Rental($this->newRelease1, 3));
        $this->statement->addRental(new Rental($this->newRelease2, 3));
        $this->statement->makeRentalStatement();
        $this->assertAmountAndPointsForReport(18.0, 4);
    }

    public function testSingleChildrensStatement()
    {
        $this->statement->addRental(new Rental($this->childrens, 3));
        $this->statement->makeRentalStatement();
        $this->assertAmountAndPointsForReport(1.5, 1);
    }

    public function testMultipleRegularStatement()
    {
        $this->statement->addRental(new Rental($this->regular1, 1));
        $this->statement->addRental(new Rental($this->regular2, 2));
        $this->statement->addRental(new Rental($this->regular3, 3));
        $this->statement->makeRentalStatement();
        $this->assertAmountAndPointsForReport(7.5, 3);
    }

    public function testRentalStatementFormat()
    {
        $this->statement->addRental(new Rental($this->regular1, 1));
        $this->statement->addRental(new Rental($this->regular2, 2));
        $this->statement->addRental(new Rental($this->regular3, 3));

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tRegular 1\t2.0\n" .
            "\tRegular 2\t2.0\n" .
            "\tRegular 3\t3.5\n" .
            "You owed 7.5\n" .
            "You earned 3 frequent renter points\n",
            $this->statement->makeRentalStatement());
    }

    protected function setUp()
    {
        $this->statement = new RentalStatement("Customer Name");
        $this->newRelease1 = new NewReleaseMovie("New Release 1");
        $this->newRelease2 = new NewReleaseMovie("New Release 2");
        $this->childrens = new ChildrensMovie("Childrens");
        $this->regular1 = new RegularMovie("Regular 1");
        $this->regular2 = new RegularMovie("Regular 2");
        $this->regular3 = new RegularMovie("Regular 3");
    }
}