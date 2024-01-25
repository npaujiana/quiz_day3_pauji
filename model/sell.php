<?php

class Sell {
	private string $name_plant;
	private string $category;
	private int $quantity;
	private int $price;
	private bool $isSelling;

	//Constructor
	public function __construct(string $name_plant, string $category, int $quantity, int $price, bool $isSelling) {
		$this->name_plant = $name_plant;
		$this->category = $category;
		$this->quantity = $quantity;
		$this->price = $price;
		$this->isSelling = $isSelling;
	}

	public function __construct2() {}

	function setQuantity(int $quantity) {
		$this->quantity = $quantity;
	}

	//Get Behavior
	function getNamePlant() : string {
		return $this->name_plant;
	}

	function getCategory() : string {
		return $this->category;
	}

	function getQuantity() : int {
		return $this->quantity;
	}

	function getPrice() : int {
		return $this->price;
	}

	function getIsSelling() : bool {
		return $this->isSelling;
	}
};