<?php
namespace VideoStore;

use VideoStore\Movie\MovieCategory;

/**
 * @deprecated
 * Adapter to use new code on legacy system
 **/
class ChildrensMovie extends Movie
{
    /**
     * ChildrensMovie constructor.
     */
    public function __construct(string $title)
    {
        parent::__construct($title, MovieCategory::Children());
    }
}