<?php

class invincibilityScroll extends Item
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
		$this->name = "Scroll of Invincibility";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0042";
		$this->description = "This " . $this->name . " grants you the spell of invincibility.";
		$this->minprice = 800;
		$this->maxprice = 1000;
		$this->level = 15;
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->addToSpells(new invincibilitySpell(), $this))
		{
			return true;
		} else {
			return false;
		}
	}
}