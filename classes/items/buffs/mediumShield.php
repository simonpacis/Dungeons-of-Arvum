<?php

class mediumShield
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
		$this->color = "#0070ff";
		$this->rarity = "strong";
		$this->id = "0026";
		$this->shield = 25;
		$this->description = "This " . $this->name . " grants you " . $this->shield . " additional shield.";
	}

	public function use($thisplayer)
	{
		$thisplayer->addShield($this->shield);
		return true;
	}
}