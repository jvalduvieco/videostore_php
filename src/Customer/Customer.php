<?php
namespace VideoStore\Customer;

class Customer
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function getName(): string
    {
        return $this->name;
    }
}