<?php

class reScroll extends Item
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
	public $spell;
	public function __construct()
	{
		$this->name = "Rescroll";
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0046";
		$this->description = "Rescroll is the object obtained after using rescroller. ";
		$this->minprice = 50;
		$this->maxprice = 70;
		$this->spell = null;
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

	public function created($spell)
	{
		$this->spell = $spell;
		$this->description = "This " . $this->name . " grants you \"" . $this->spell->name . "\".";
	}

}