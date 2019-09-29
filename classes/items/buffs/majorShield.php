<?php

class majorShield
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Major Shieldgiver";
		$this->color = "#a335ee";
		$this->rarity = "strong";
		$this->id = "0027";
		$this->shield = 10;
		$this->description = "This " . $this->name . " grants you " . $this->shield . " additional shield.";
	}

	public function use($thisplayer)
	{
		$thisplayer->addShield($this->shield);
		return true;
	}
}