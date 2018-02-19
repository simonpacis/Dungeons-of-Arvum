<?php

class potTreasure
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
		$this->loot = getItem("common", "strong", false, true, 1, true);
	}

	public function pickup($player)
	{
		$player->addToInventory($this->loot);
		
	}
}