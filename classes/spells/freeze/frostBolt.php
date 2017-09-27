<?php

class frostBolt extends Spell
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
	public $freeze_duration;
	public function __construct()
	{
		$this->name = "Frostbolt";
		$this->color = "#ffffff";
		$this->id = "0018";
		$this->rarity = "common";
		$this->description = "Has a 50% chance to freeze enemies in radius.";
		$this->damage_type = "magical";
		$this->radius_type = "cube";
		$this->radius_var_1 = 7;
		$this->radius_var_2 = 7;
		$this->level = 3;
		$this->mana_use = 5;
		$this->freeze_duration = 3;
	}
	public function describe($clientid)
	{
		status($clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . " Freeze duration: " . round($this->freeze_duration) . ". Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");
		return true;
	}

	public function duplicate($thisplayer, $notify = true)
	{
		$this->freeze_duration = $this->freeze_duration * 1.2;
		if(!$notify)
		{
			status($thisplayer->clientid, "You obtained another " . $this->name . ", which increased the freeze duration to " . round($this->freeze_duration));
		}
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		parent::freeze_in_radius(round($this->freeze_duration), $this->damage_type, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, 50);
		parent::unset_radius($thisplayer);
		return true;
	}
}