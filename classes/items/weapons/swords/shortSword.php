<?php

class shortSword extends Weapon
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
	public $price;
	
	public function __construct()
	{
		$this->name = "Shortsword";
		$this->color = "#fff";
		$this->id = "0005";
		$this->rarity = "common";
		$this->description = "An ordinary sword that cuts.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 1;
		$this->radius_var_2 = 1;
		$this->attack_speed = 0.1;
		$this->last_attack = 0;
		$this->level = 2;
		$this->minprice = 30;
		$this->maxprice = 40;
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
			parent::damage_in_radius(2, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			parent::unset_radius($thisplayer);
		}
	}
}