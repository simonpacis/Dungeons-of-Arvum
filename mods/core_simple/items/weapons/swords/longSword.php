<?php

class longSword extends Weapon
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
		$this->name = "Longsword";
		$this->color = "#1eff00";
		$this->id = "0016";
		$this->rarity = "uncommon";
		$this->description = "A longer sword.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->attack_speed = 0.75;
		$this->last_attack = 0;
		$this->damage = 10;
		$this->damage_type = "melee";
		$this->level = 4;
		$this->minprice = 30;
		$this->maxprice = 50;
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
			parent::damage_in_radius(3, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			parent::unset_radius($thisplayer);
		}	
	}
}
