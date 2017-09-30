<?php

class fireBall extends Spell
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
		$this->name = "Fireball";
		$this->color = "#ffffff";
		$this->id = "0017";
		$this->rarity = "common";
		$this->description = "Shoots a mighty fireball from your hands.";
		$this->damage_type = "magical";
		$this->radius_type = "cube";
		$this->radius_var_1 = 5;
		$this->radius_var_2 = 5;
		$this->level = 1;
		$this->mana_use = 5;
		$this->damage = 3;
	}

	public function describe($clientid)
	{
		status($clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . " Damage: " . round($this->damage) . ". Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");
		return true;
	}

	public function duplicate($thisplayer, $notify = true)
	{
		$this->damage = $this->damage * 1.3;
		$this->mana_use = round($this->mana_use * 1.5);
		if(!$notify)
		{
			status($thisplayer->clientid, "You obtained another " . $this->name . ", which increased the damage to " . round($this->damage) . ", and the mana usage to " . $this->mana_use . ".");
		}
		return true;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		parent::do_in_radius("damage", [round($this->damage), $this->damage_type, $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
		return true;
	}
}