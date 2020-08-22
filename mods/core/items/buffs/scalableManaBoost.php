<?php

class scalableManaBoost extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Scalable Mana Boost";
		$this->color = "#0070ff";
		$this->rarity = "strong";
		$this->id = "0040";
		$this->description = "This " . $this->name . " gives you 10 times your level more permanent mana!";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$additionalmana = $thisplayer->level * 10;
		$thisplayer->maxmana = $thisplayer->maxmana + $additionalmana;
		$thisplayer->curmana = $thisplayer->curmana + $additionalmana;
		return true;
	}
}