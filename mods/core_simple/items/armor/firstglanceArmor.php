<?php

class firstglanceArmor extends Armor
{
	public $hook;
	public $wielded;
	public $resistance_type;
	public $resistance_percentage;
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $maxuses;
	public $curuses;
	public $level;
	public $wield_type;

	public function __construct()
	{
		$this->name = "First Glance Armor";
		$this->color = "#a335ee";
		$this->id = "0057";
		$this->rarity = "epic";
		$this->description = "The first attack from a mob is completely blocked. Does not work for effects.";
		$this->maxuses = 500;
		$this->curuses = $this->maxuses;
		$this->wielded = false;
		$this->hook = "first_damage";
		$this->resistance_type = "melee";
		$this->wield_type = "armor";
		$this->level = 7;
		$this->minprice = 600;
		$this->maxprice = 700;
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->wield($this, $this->wield_type);
	}

	public function runHook()
	{
		$damage = func_get_arg(0);
		$type = func_get_arg(1);
		$player = func_get_arg(2);
		$dealer = func_get_arg(3);

		if($this->wielded)
		{
			if($dealer->hasHit($player))
			{
				return $damage;
			} else {
				$dealer->hit($player);
				$this->curuses = $this->curuses - $damage;
				if($this->curuses <= 0)
				{
					$player->removeFromInventory($this, false, true, true);
					status($player->clientid, "Your " . $this->name . " broke.");
					$player->unwield($this, $this->wield_type);
					$this->wielded = false;
				}
				return 0;

			}	
			
			
		} else {
			return [false, $damage];
		}
	}
}