<?php
require_once "farmer.php";
require_once "cart.php";
require_once "history.php";

class Buyer extends User
{
    private $buyers_data = [];
    private $username = [];
    private $cart = [];
    private $history = [];

    // set behavior

    public function __construct()
    {

    }
    public function setBuyersData(User $buyers_data)
    {
        $this->buyers_data = $buyers_data;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function setHistory(History $history)
    {
        $this->history = $history;
    }

    //get behavior
    public function getBuyersData()
    {
        return $this->buyers_data;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getHistory()
    {
        return $this->history;
    }

};
