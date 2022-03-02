<?php

class angelicShoes extends Item
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
		$this->name = "Angelic Shoes";
		$this->color = "#a335ee";
		$this->id = "0038";
		$this->rarity = "epic";
		$this->description = "Hold down that movement button even more! Adds 10 to stamina. Stacks.";
		$this->level = 7;
		$this->minprice = 170;
		$this->maxprice = 250;
		$this->hook = "before_stamina_use";
		$this->extra_stamina = 10;
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
			$thisplayer->maxstamina = $thisplayer->maxstamina - 10;
			$thisplayer->curstamina = $thisplayer->curstamina - 10;
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
				$thisplayer->maxstamina = $thisplayer->maxstamina + 10;
				array_push($this->granted, $thisplayer->clientid);
			}
		}
	}
}