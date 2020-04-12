<?php

class invincibilitySpell extends Spell
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
	public $mana_use;
	public function __construct()
	{
		$this->name = "Invincibility";
		$this->color = "#ff8000";
		$this->id = "0043";
		$this->rarity = "legendary";
		$this->description = "Makes you invincible for 10 seconds. Uses 80% of your mana.";
		$this->level = 15;
		$this->invincibility_duration = 10;
		$this->mana_use = 1000;
		$this->panel_value = "invcbl " . $this->invincibility_duration . "s";
		$this->hook = "mana_increase";
	}

	public function panelValue()
	{
		return [$this->panel_value, "#ff8000"];
	}

	public function describe($clientid)
	{
		status($clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . " Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");
		return true;
	}

	public function duplicate($thisplayer, $notify = true)
	{
		status($thisplayer->clientid, "You obtained another " . $this->name . ". Shouldn't be possible!");
		return true;
	}

	public function use($thisplayer)
	{
		$thisplayer->invincible($this->invincibility_duration, $thisplayer);
		return true;
	}

	public function created($thisplayer)
	{
		$this->mana_use = round($thisplayer->maxmana*0.8);
		return true;
	}

	public function runHook()
	{
		$thisplayer = func_get_arg(0);
		$this->mana_use = round($thisplayer->maxmana*0.8);
	}

}