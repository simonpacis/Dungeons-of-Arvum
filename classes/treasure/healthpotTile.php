<?php

class healthpotTile
{
	public $solid;
	public $representation;
	public $color;
	public $amount;
	public function __construct($amount = 1)
	{
		$this->solid = false;
		$this->representation = "&";
		$this->color = "#5CCC6B";
		$this->amount = $amount;
	}

	public function pickup($player)
	{
		$player->addHealthpot($this->amount);
	}
}