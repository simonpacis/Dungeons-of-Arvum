<?php

class scrollOfFifteen extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public $minprice;
	public $maxprice;
	public $price;
	public $spell;
	public function __construct()
	{
		$this->name = "Scroll of Symeon";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0052";
		$this->description = "The Scroll of Symeon grants you fifteen upgrades in a given scroll type.";
		$this->minprice = 1100;
		$this->maxprice = 1600;
		parent::__construct();
	}

	
	public function use($thisplayer)
	{
		$thisplayer->request('itemUse', $this);
		return false;
	}

	public function useRequest($thisplayer)
	{
		status($thisplayer->clientid, "Type either \"Q\" or \"E\" to upgrade this spell fifteen times (or as many as is possible). Type \"0\" to cancel.", "#ffff00", true);
		return true;
	}

	public function useResponse($message, $thisplayer)
	{
		$message = ucfirst($message);
		if($message == "E")
		{
			if(isset($thisplayer->spells[1]))
			{
				for ($i=0; $i < 15; $i++) { 
					$thisplayer->spells[1]->duplicate($thisplayer, false);
				}
				unset($thisplayer->inventory[$thisplayer->getInventoryIndex($this)]);
				return true;
			} else {
				return false;
			}
			
		}
		if($message == "Q")
		{
			if(isset($thisplayer->spells[0]))
			{
				for ($i=0; $i < 15; $i++) { 
					$thisplayer->spells[0]->duplicate($thisplayer, false);
				}
				unset($thisplayer->inventory[$thisplayer->getInventoryIndex($this)]);
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	public function created($thisplayer)
	{
		return true;
	}

}