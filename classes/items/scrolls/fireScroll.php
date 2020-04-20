<?php

class fireScroll extends Item
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
		$this->name = "Scroll of Fire";
		$this->color = "#fff";
		$this->rarity = "uncommon";
		$this->id = "0019";
		$this->description = "This " . $this->name . " grants you spells of fire.";
		$this->minprice = 50;
		$this->maxprice = 70;
		$this->spell = new fireBall();
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