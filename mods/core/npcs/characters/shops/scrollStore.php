<?php

class scrollStore extends Shop
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $stock;
	public $amount_of_items;

	public function __construct()
	{
		$this->name = "Magical Store";
		$this->representation = "M";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
		$this->stock = [];
		$this->selection = ["iceScroll", "fireScroll", "lightningScroll", "manaJug", "manaPotion", "majorManaPotion", "rescroller"];
		$this->amount_of_items = rand(1,3);

	}

}
