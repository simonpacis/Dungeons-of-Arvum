<?php

class heavenlyShoes extends Item
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
		$this->name = "Heavenly Shoes";
		$this->color = "#ff8000";
		$this->id = "0039";
		$this->rarity = "legendary";
		$this->description = "What even is stamina? You've essentially got unlimited.";
		$this->level = 13;
		$this->minprice = 2000;
		$this->maxprice = 2600;
		$this->hook = "before_stamina_use";
		$this->extra_stamina = 10000;
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
			$thisplayer->maxstamina = $thisplayer->maxstamina - 10000;
			$thisplayer->curstamina = $thisplayer->curstamina - 10000;
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
				$thisplayer->maxstamina = $thisplayer->maxstamina + 10000;
				$thisplayer->curstamina = $thisplayer->maxstamina;
				array_push($this->granted, $thisplayer->clientid);
			}
		}
	}
}