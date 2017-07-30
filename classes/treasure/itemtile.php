<?php

class Itemtile
{
	public $solid;
	public $representation;
	public $color;
	public $healamount;
	public function __construct($item)
	{
		$this->solid = false;
		$this->representation = "$";
		$this->color = "#ff0000";
		$this->item = $item;
	}

	public function pickup($player)
	{
		status($player->clientid, "Someone else has dropped this item.", "#ffff00");
		$player->addToInventory($this->item);
	}
}