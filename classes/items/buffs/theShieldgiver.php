<?php

class theShieldgiver
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "THE SHIELDGIVER";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0028";
		$this->description = "This " . $this->name . " grants you full shield.";
	}

	public function use($thisplayer)
	{
		$thisplayer->addShield(($thisplayer->maxshield-$thisplayer->curshield));
		return true;
	}
}