<?php

class Plant
{
    private string $name;
    private string $category;
    private int $quantity;
    private int $price;
    // Constructor
    public function __construct(string $name, string $category, int $quantity, int $price)
    {
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function __construct2()
    {}

    // get behavior
    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

};
