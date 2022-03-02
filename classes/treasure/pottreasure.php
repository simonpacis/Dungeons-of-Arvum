<?php

class potTreasure
{
	public $solid;
	public $representation;
	public $color;
	public $loot;
	public function __construct()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->solid = false;
		$this->representation = "$";
		$this->color = "#ffd700";
		$this->loot = getItem("common", "strong", false, true, 1, true);
	}

	public function pickup($player)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		//$player->addToInventory($this->loot);
		$player->addCoins(rand(1,50));
	}
}
