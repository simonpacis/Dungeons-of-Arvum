<?php

class bountyHunter extends Shop
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
		$this->name = "The Bounty Hunter";
		$this->representation = "B";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
		$this->stock = [];
		$this->selection = ["legendaryLocator", "shortBow", "longBow", "boneBow"];
		$this->amount_of_items = rand(1,count($this->selection));

	}

}