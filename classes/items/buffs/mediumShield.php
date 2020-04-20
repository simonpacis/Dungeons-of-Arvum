<?php

class mediumShield extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Medium Shieldgiver";
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0026";
		$this->shield = 5;
		$this->description = "This " . $this->name . " grants you " . $this->shield . " additional shield.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->addShield($this->shield);
		return true;
	}
}