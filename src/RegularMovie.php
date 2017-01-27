<?php


namespace VideoStore;

use VideoStore\Movie\MovieCategory;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class RegularMovie extends Movie
{
    /**
     * RegularMovie constructor.
     */
    public function __construct(string $title)
    {
        parent::__construct($title, MovieCategory::Regular());
    }
}
