<?php

class dwarvenMarket extends Shop
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $stock;
	public $allowed_items;
	public $amount_of_items;

	public function __construct()
	{
		$this->name = "Dwarven Market";
		$this->representation = "D";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
		$this->stock = [];
		$this->selection = ["brandistock", "pike", "ironSpear", "leatherArmor", "fireBallScroll", "frostBallScroll"];
		if(rand(1,100) > 90)
		{
			array_push($this->selection, "skullArmor");
		}
		$this->amount_of_items = 6;

	}

}