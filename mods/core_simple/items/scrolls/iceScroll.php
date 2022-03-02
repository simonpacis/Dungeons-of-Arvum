<?php

class iceScroll extends Item
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
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you Ice spells.";
		$this->minprice = 50;
		$this->maxprice = 70;
		$this->spell = new frostBall();
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->addToSpells(new frostBall(), $this))
		{
			return true;
		} else {
			return false;
		}
	}
}