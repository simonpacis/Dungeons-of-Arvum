<?php

class dagger extends Weapon
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
	public $no_sell;
	
	public function __construct()
	{
		$this->name = "Dagger";
		$this->color = "#fff";
		$this->id = "0014";
		$this->rarity = "common";
		$this->radius_type = "cube";
		$this->radius_var_1 = 1;
		$this->radius_var_2 = 1;
		$this->attack_speed = 0.5; // Seconds per attack
		$this->last_attack = 0;
		$this->level = 1;
		$this->no_sell = true;
		$this->description = "1 damage, " . $this->attack_speed . " seconds attack speed.";
		parent::__construct();

	}

	public function use($thisplayer)
	{
		if(parent::can_attack($this, $thisplayer, false))
		{
			parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
		}
	}

	public function useRadius($thisplayer)
	{
		if(parent::can_attack($this, $thisplayer))
		{
			parent::damage_in_radius(1, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			parent::unset_radius($thisplayer);
		}
	}
}