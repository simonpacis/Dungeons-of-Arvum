<?php

class greatThawer extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Piece of Burning Coal";
		$this->color = "#0070ff";
		$this->rarity = "strong";
		$this->id = "0051";
		$this->description = $this->name . " will remove any freeze effect you have.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->isFrozen())
		{
			$thisplayer->unFreeze();
			return true;
		} else {
			status($thisplayer->clientid, "You cannot use this item at this time.");
			return false;
		}
	}

	public function created($thisplayer)
	{
		return true;
	}

}