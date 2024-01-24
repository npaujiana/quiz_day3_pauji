<?php
require_once "plants.php";
require_once "sell.php";
require_once "user.php";
require_once "review.php";

class Farmer extends User
{
    private $plants = [];
    private $farmers_data = [];
    private $username = [];
    private $sells = [];
    private $reviews = [];

    public function __construct()
    {

    }

    // set behavior
    public function setFarmerData(User $farmer_data)
    {
        $this->farmers_data[] = $farmer_data;
    }

    public function setUsername(string $username)
    {
        $this->username[] = $username;
    }

    public function setPlants(Plant $plant)
    {
        $this->plants[] = $plant;
    }

    public function setSells(Sell $sell)
    {
        $this->sells[] = $sell;
    }

    public function setReviews(Review $review)
    {
        $this->reviews[] = $review;
    }

    //get behavior
    public function getFarmersData()
    {
        return $this->farmers_data;
    }

    public function getUsername(): array
    {
        return $this->username;
    }

    public function getPlants()
    {
        return $this->plants;
    }

    public function getSells()
    {
        return $this->sells;
    }

    public function getReviews()
    {
        return $this->reviews;
    }
};
