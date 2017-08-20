<?php

class skullArmor extends Armor
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
		$this->name = "Skull Armor";
		$this->color = "#a335ee";
		$this->id = "0015";
		$this->rarity = "epic";
		$this->maxuses = 1000;
		$this->curuses = $this->maxuses;
		$this->wielded = false;
		$this->hook = ["before_damage", "after_kill"];
		$this->resistance_percentage = 0;
		$this->resistance_type = "all";
		$this->wield_type = "armor";
		$this->level = 6;
	}

	public function use($thisplayer)
	{
		$thisplayer->wield($this, $this->wield_type);
	}

	public function describe($clientid)
	{
		status($clientid, "Reduces all damage by " . $this->resistance_percentage * 100 . "%. Adds 0.5% to this, for every kill you get. Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");
	}

	public function runHook()
	{
		$hook = func_get_arg((func_num_args()-1));
		if($hook == "before_damage")
		{
			$damage = func_get_arg(0);
			$type = func_get_arg(1);
			$player = func_get_arg(2);

			if($this->wielded)
			{
				$damage_to_remove = round($damage*$this->resistance_percentage);
				$this->curuses = $this->curuses - $damage_to_remove;
				if($this->curuses <= 0)
				{
					$player->removeFromInventory($this, false, true, true);
					status($player->clientid, "Your " . $this->name . " broke.");
					$player->unwield($this, $this->wield_type);
					$this->wielded = false;
				}
				return round($damage-$damage_to_remove);
			} else {
				return [false, $damage];
			}
		} elseif($hook == "after_kill") {
			$this->resistance_percentage = $this->resistance_percentage + 0.005;
			return true;
		}
	}
}