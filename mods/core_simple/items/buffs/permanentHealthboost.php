<?php

class permanentHealthboost extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct($additional_Health = "random", $random_min = 1, $random_max = 5, $name = "Scroll of Constitution")
	{
		$this->name = $name;
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0005";
		if($additional_Health != "random")
		{
			$this->additional_health = $additional_Health;
		} else {
			$this->additional_health = rand($random_min,$random_max);
		}
		$this->description = "Scroll of Constitution grants you between " . $random_min . " and " . $random_max . " additional permanent health.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->maxhp = $thisplayer->maxhp + $this->additional_health;
		$thisplayer->curhp = $thisplayer->curhp + $this->additional_health;
		status($thisplayer->clientid, "You receive " . $this->additional_health . " additional HP!", "#ffff00");
		return true;
	}

	public function created($thisplayer)
	{
		$this->description = "This " . $this->name . " grants you " . $this->additional_health . " additional permament health.";
		return true;
	}
}