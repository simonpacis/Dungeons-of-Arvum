<?php

class thawer extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Piece of Ember";
		$this->color = "#1eff00";
		$this->rarity = "uncommon";
		$this->id = "0050";
		$this->description = $this->name . " will remove any slow effect you have.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->isSlowed())
		{
			$thisplayer->unSlow();
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