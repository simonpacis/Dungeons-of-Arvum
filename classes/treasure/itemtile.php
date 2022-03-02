<?php

class Itemtile
{
	public $solid;
	public $representation;
	public $color;
	public $healamount;
	public function __construct($item)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->solid = false;
		$this->representation = "$";
		$this->color = "#ff0000";
		$this->item = $item;
	}

	public function pickup($player)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		status($player->clientid, "Someone else has dropped this item.", "#ffff00");
		$player->addToInventory($this->item);
	}
}
