<?php

class majorManaPotion extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Major Mana Potion";
		$this->color = "#0070ff";
		$this->rarity = "strong";
		$this->id = "0032";
		$this->mana = 50;
		$this->description = "This " . $this->name . " grants you " . $this->mana . " mana";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->addMana($this->mana);
		return true;
	}
}