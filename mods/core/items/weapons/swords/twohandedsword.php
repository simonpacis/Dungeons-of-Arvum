<?php

class twohandedsword extends Weapon
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
	public function __construct()
	{
		$this->name = "Two-handed Sword";
		$this->color = "#0070ff";
		$this->id = "0044";
		$this->rarity = "strong";
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->attack_speed = 0.6;
		$this->last_attack = 0;
		$this->damage = 10;
		$this->damage_type = "melee";
		$this->level = 12;
		$this->description = "A big old nasty sword. " . $this->damage . " damage, " . $this->attack_speed . " seconds attack speed. Level: " . $this->level;

		$this->minprice = 60;
		$this->maxprice = 90;
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
			parent::damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			parent::unset_radius($thisplayer);
		}	
	}
}
