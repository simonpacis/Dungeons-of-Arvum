<?php

class Treasure
{
	public $solid;
	public $representation;
	public $color;
	public $loot;
	public function __construct()
	{
		$this->solid = false;
		$this->representation = "$";
		$this->color = "#ffd700";
		$this->loot = getItem("common", "uncommon", false, true);
	}

	public function pickup($player)
	{
		$rand = rand(0,100);
		if($rand > 80)
		{
			$player->addHealthpot(rand(1,5));
		} else {
			$player->addToInventory($this->loot);
		}
	}
}