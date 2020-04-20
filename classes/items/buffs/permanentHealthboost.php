<?php

class permanentHealthboost extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct($additional_Health = 1, $random_min = 1, $random_max = 5, $name = "Scroll of Constitution")
	{
		$this->name = $name;
		$this->color = "#fff";
		$this->rarity = "uncommon";
		$this->id = "0005";
		if($additional_Health != "random")
		{
			$this->additional_health = $additional_Health;
		} else {
			$this->additional_health = rand($random_min,$random_max);
		}
		$this->description = "This " . $this->name . " grants you " . $this->additional_health . " additional permament health.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->maxhp = $thisplayer->maxhp + $this->additional_health;
		$thisplayer->curhp = $thisplayer->curhp + $this->additional_health;
		status($thisplayer->clientid, "You receive " . $this->additional_health . " additional HP!", "#ffff00");
		return true;
	}
}