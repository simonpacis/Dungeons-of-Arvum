<?php

class queronsLongSword extends Weapon
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
		$this->name = "Queron's Longsword";
		$this->color = "#a335ee";
		$this->id = "0054";
		$this->rarity = "epic";
		$this->description = "Damage: 25. Atk. spd.: 25 dps. Level: 13. A sword smithed by the legendary Queron.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->attack_speed = 1;
		$this->last_attack = 0;
		$this->damage = 25;
		$this->damage_type = "melee";
		$this->level = 13;
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
