<?php

class healthJug extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Health Jug";
		$this->color = "#a335ee";
		$this->rarity = "epic";
		$this->id = "0030";
		$this->description = "This " . $this->name . " grants you full HP.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->heal(($thisplayer->maxhp-$thisplayer->curhp));
		return true;
	}
}