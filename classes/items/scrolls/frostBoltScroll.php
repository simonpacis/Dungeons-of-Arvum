<?php

class frostBallScroll
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Scroll of Frostball";
		$this->color = "#fff";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you the Frostball spell.";
	}

	public function use($thisplayer)
	{
		$thisplayer->addToSpells(new frostBall());
		return true;
	}
}