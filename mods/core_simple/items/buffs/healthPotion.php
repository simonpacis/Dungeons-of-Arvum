<?php

class healthPotion extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Health Potion";
		$this->color = "#ffffff";
		$this->rarity = "common";
		$this->id = "0029";
		$this->heal = 10;
		$this->description = "This " . $this->name . " grants you " . $this->heal . " HP";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->heal($this->heal);
		return true;
		/*if($thisplayer->curhp < $thisplayer->maxhp)
		{
			$thisplayer->heal($this->heal);
			return true;
		} else {
			status($this->clientid, "You do not need to heal.", "#5CCC6B");
			return false;
		}*/
		
	}
}