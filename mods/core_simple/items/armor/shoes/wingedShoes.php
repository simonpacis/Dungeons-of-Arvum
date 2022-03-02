<?php

class wingedShoes extends Item
{
	public $name;
	public $color;
	public $id;
	public $rarity;
	public $description;
	public $level;
	public $minprice;
	public $maxprice;
	public $hook;
	public $granted;
	
	public function __construct()
	{
		$this->name = "Winged Shoes";
		$this->color = "#0070ff";
		$this->id = "0036";
		$this->rarity = "strong";
		$this->description = "Hold down that movement button! Adds 5 to stamina. Stacks.";
		$this->level = 4;
		$this->minprice = 100;
		$this->maxprice = 140;
		$this->hook = "before_stamina_use";
		$this->extra_stamina = 5;
		$this->hook_return = false; //This allows us to stack them, if the player has multiple. 
		$this->granted = [];
		parent::__construct();
	}

	public function use($thisplayer)
	{
		status($thisplayer->clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . " Rarity: " . ucfirst($this->rarity) . ".", "#ffff00");
	}

	public function removed($thisplayer)
	{
		if(in_array($thisplayer->clientid, $this->granted))
		{
			$thisplayer->maxstamina = $thisplayer->maxstamina - 5;
			$thisplayer->curstamina = $thisplayer->curstamina - 5;
			$this->granted = [];
		}
	}

	public function runHook()
	{
		$thisplayer = func_get_arg(0);
		if($thisplayer->level >= $this->level)
		{
			if(!in_array($thisplayer->clientid, $this->granted))
			{
				$thisplayer->maxstamina = $thisplayer->maxstamina + 5;
				array_push($this->granted, $thisplayer->clientid);
			}
		}
	}
}