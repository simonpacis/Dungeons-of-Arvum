<?php

class generalStore extends Character
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;

	public function __construct()
	{
		$this->name = "General Store";
		$this->representation = "G";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
	}

	public function tick()
	{
		global $map;
		
	}

}