<?php

class ironIngot extends Item
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
		$this->name = "Iron Ingot";
		$this->color = "#fff";
		$this->id = "0053";
		$this->rarity = "common";
		$this->description = "An iron ingot. I should talk to the blacksmith about this.";
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
