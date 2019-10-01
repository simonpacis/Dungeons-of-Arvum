<?php

class lightningScroll
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
		$this->name = "Scroll of Lightning";
		$this->color = "#fff";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you Lightning spells.";
		$this->minprice = 50;
		$this->maxprice = 70;
		$this->minprice = 0;
		$this->maxprice = 0;
	}

	public function use($thisplayer)
	{
		status($thisplayer->clientid, "Lightning spells are not yet implemented.", "#ffffff");
		return false;
		//$thisplayer->addToSpells(new frostBall());
		//return true;
	}
}