<?php

class Greattreasure
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
		$this->representation = "£";
		$this->color = "#ffd700";
		$this->loot = getItem("uncommon", "strong", false, true);
	}

	public function pickup($player)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$lootorgold = rand(1,100);
		if($lootorgold > 50)
		{		
			$player->addToInventory($this->loot);
		} else {
			$player->addCoins(rand(60,200));
		}
	}
}
