<?php

class chainmail extends Armor
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
		$this->name = "Chainmail";
		$this->color = "#0070ff";
		$this->id = "0012";
		$this->rarity = "strong";
		$this->description = "Reduces ranged damage by 40%.";
		$this->maxuses = 700;
		$this->curuses = $this->maxuses;
		$this->wielded = false;
		$this->hook = "before_damage";
		$this->resistance_percentage = 0.4;
		$this->resistance_type = "ranged";
		$this->wield_type = "armor";
		$this->level = 4;
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

		if($this->wielded)
		{
			if($type == $this->resistance_type)
			{
				$damage_to_remove = ceil($damage*$this->resistance_percentage);
				$this->curuses = $this->curuses - $damage_to_remove;
				if($this->curuses <= 0)
				{
					$player->removeFromInventory($this, false, true, true);
					status($player->clientid, "Your " . $this->name . " broke.");
					$player->unwield($this, $this->wield_type);
					$this->wielded = false;
				}
				return ceil($damage-$damage_to_remove);
			} else {
				return $damage;
			}
		} else {
			return [false, $damage];
		}
	}
}