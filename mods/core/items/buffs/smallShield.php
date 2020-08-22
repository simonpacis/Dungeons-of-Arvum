<?php

class smallShield extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Minor Shieldgiver";
		$this->color = "#ffffff";
		$this->rarity = "common";
		$this->id = "0025";
		$this->shield = 2;
		$this->description = "This " . $this->name . " grants you " . $this->shield . " additional shield.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->addShield($this->shield);
		return true;
	}
}