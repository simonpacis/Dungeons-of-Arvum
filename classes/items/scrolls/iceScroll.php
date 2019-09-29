<?php

class iceScroll
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public $minprice;
	public $maxprice;
	public $price;
	public function __construct()
	{
		$this->name = "Scroll of Ice";
		$this->color = "#fff";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you Ice spells.";
		$this->minprice = 50;
		$this->maxprice = 70;
	}

	public function use($thisplayer)
	{
		$thisplayer->addToSpells(new frostBall());
		return true;
	}
}