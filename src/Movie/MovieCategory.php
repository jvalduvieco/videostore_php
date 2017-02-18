<?php


namespace VideoStore\Movie;

class MovieCategory
{
    const NEW_RELEASE = 1;
    const CHILDREN = 2;
    const REGULAR = 3;

    /** @var int */
    private $id;

    /** @var  string */
    private $description;

    /**
     * MovieCategory constructor.
     * @param int $id
     * @param string $description
     */
    private function __construct($id, $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public static function newRelease()
    {
        return new self(self::NEW_RELEASE, "NEW RELEASE");
    }

    public static function children()
    {
        return new self(self::CHILDREN, "CHILDREN");
    }

    public static function regular()
    {
        return new self(self::REGULAR, "REGULAR");
    }

    public function getId(): int
    {
        return $this->id;
    }
}
