<?php
namespace VideoStore\Customer;

class Customer
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get A Customer Entity by Name
     * @TODO This will be eventually replaced by a repository
     * @param string $name
     * @return Customer
     */
    public static function findByName(string $name)
    {
        return new self($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
