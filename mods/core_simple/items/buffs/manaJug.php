<?php

class manaJug extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Mana Jug";
		$this->color = "#a335ee";
		$this->rarity = "epic";
		$this->id = "0033";
		$this->description = "This " . $this->name . " grants you full mana.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->addMana(($thisplayer->maxmana-$thisplayer->curmana));
		return true;
	}
}