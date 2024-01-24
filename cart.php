<?php

class Cart
{
    private string $name;
    private int $plant_quantity;
    private int $total_price;
    // Constructor
    public function __construct(string $name, int $plant_quantity, int $total_price)
    {
        $this->name = $name;
        $this->plant_quantity = $plant_quantity;
        $this->total_price = $total_price;
    }

    public function __construct2()
    {}

    // get behavior
    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->plant_quantity;
    }

    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

};
