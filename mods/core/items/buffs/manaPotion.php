<?php

class manaPotion extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Mana Potion";
		$this->color = "#ffffff";
		$this->rarity = "common";
		$this->id = "0031";
		$this->mana = 10;
		$this->description = "This " . $this->name . " grants you " . $this->mana . " mana";
	}

	public function use($thisplayer)
	{
		$thisplayer->addMana($this->mana);
		return true;
	}
}