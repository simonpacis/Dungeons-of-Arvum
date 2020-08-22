<?php

class ironSpear extends Weapon
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
		$this->name = "Iron Spear";
		$this->color = "#1eff00";
		$this->id = "0021";
		$this->rarity = "uncommon";
		$this->description = "An iron spear. Has 10% chance to hit yourself.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 3;
		$this->radius_var_2 = 3;
		$this->level = 3;
		$this->attack_speed = 0.5;
		$this->last_attack = 0;
		$this->damage = 10;
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
			$chance = rand(1,100);
			if($chance < 90)
			{
				parent::damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			} else {
				$thisplayer->damage($this->damage, "melee");
			}
			parent::unset_radius($thisplayer);
		}
	}
}