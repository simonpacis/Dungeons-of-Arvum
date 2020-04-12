<?php

class bowSeller extends Shop
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
	public $infinite_stock;

	public function __construct()
	{
		$this->name = "The Bowman";
		$this->representation = "B";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
		$this->stock = [];
		$this->selection = ["longbow", "shortbow"];
		$this->infinite_stock = true;
		$this->amount_of_items = rand(1,2);

	}

}
