<?php

class lightningScroll extends Item
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
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you Lightning spells.";
		$this->minprice = 50;
		$this->maxprice = 70;
		$this->minprice = 0;
		$this->maxprice = 0;
		$this->spell = new lightningBall();
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->addToSpells($this->spell, $this))
		{
			return true;
		} else {
			return false;
		}
	}
}