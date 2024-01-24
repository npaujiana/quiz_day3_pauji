<?php

class History
{
    private string $name_user;
    private string $name_plant;
    private int $quantity;
    private int $total_price;
    private string $type_payment;
    private string $address;
    // Constructor
    public function __construct(string $name_user, string $name_plant, int $quantity, int $total_price, string $type_payment, string $address)
    {
        $this->name_user = $name_user;
        $this->name_plant = $name_plant;
        $this->quantity = $quantity;
        $this->total_price = $total_price;
        $this->type_payment = $type_payment;
        $this->address = $address;
    }

    public function __construct2()
    {}

    // get behavior
    public function getNameUser(): string
    {
        return $this->name_user;
    }

    public function getNamePlant(): string
    {
        return $this->name_plant;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    public function getTypePayment(): string
    {
        return $this->type_payment;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

};
