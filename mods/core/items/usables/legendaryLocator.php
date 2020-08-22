<?php

class legendaryLocator extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Legendary Stone";
		$this->color = "#0070ff";
		$this->rarity = "strong";
		$this->id = "0047";
		$this->minprice = 250;
		$this->maxprice = 500;
		$this->level = 10;
		$this->description = $this->name . " sets your waypoint to a random legendary monster. Be careful!";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		global $mobs;
		$localmobs = $mobs;
		shuffle($localmobs);
		foreach($localmobs as $mob)
		{
			if($mob->rarity == "legendary")
			{
				status($thisplayer->clientid, $mob->name . " has been found. Check your waypoint!", "#ff8000");
				status($thisplayer->clientid, "Waypoint set.");
				$thisplayer->waypoint_x = $mob->x + 1;
				$thisplayer->waypoint_y = $mob->y;
				break;
			}
		}
		unset($localmobs);
		return true;
	}

	public function created($thisplayer)
	{
		return true;
	}

}