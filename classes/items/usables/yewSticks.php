<?php

class yewSticks extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $maxuses;
	public $curuses;
	public $description;
	public $radius_type;
	public $radius_var_1;
	public $radius_var_2;
	public $level;
	public function __construct()
	{
		$this->name = "Yew Stick";
		$this->color = "#fff";
		$this->id = "0055";
		$this->rarity = "common";
		$this->description = "An yew stick. I should talk to the bowyer about this.";
		$this->maxuses = 1;
		$this->curuses = 1;
		$this->level = 1;
		$this->minprice = 10;
		$this->maxprice = 30;
		parent::__construct();
	}

	public function use($thisplayer)
	{
		status($thisplayer->clientid, $this->description, "#ffffff");
		return false;
	}

}
