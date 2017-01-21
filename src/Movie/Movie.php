<?php
namespace VideoStore\Movie;

class Movie
{
    /** @var string */
    private $title;

    /** @var string */
    private $category;

    /**
     * Movie constructor.
     * @param string $title
     * @param MovieCategory $category
     */
    public function __construct(string $title, MovieCategory $category)
    {
        $this->title = $title;
        $this->category = $category;
    }

    /** @return string */
    public function getTitle (): string {
        return $this->title;
    }

    /** @return MovieCategory */
    public function getCategory(): MovieCategory
    {
        return $this->category;
    }
}