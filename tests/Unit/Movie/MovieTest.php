<?php
namespace VideoStore\Tests\Unit\Movie;

use VideoStore\Movie\Movie;
use VideoStore\Movie\MovieCategory;

class MovieTest extends \PHPUnit_Framework_TestCase
{
    function testICanCreateAMovie()
    {
        $movie = new Movie("A Title", MovieCategory::Children());
        $this->assertEquals(MovieCategory::Children(), $movie->getCategory());
        $this->assertEquals("A Title", $movie->getTitle());
    }
}