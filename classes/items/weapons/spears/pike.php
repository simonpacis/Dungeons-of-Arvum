<?php

class pike extends Weapon
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
		$this->name = "Pike";
		$this->color = "#0070ff";
		$this->id = "0024";
		$this->rarity = "strong";
		$this->description = "An ordinary pike. Has 30% chance to damage yourself.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 3;
		$this->radius_var_2 = 3;
		$this->attack_speed = 0.75;
		$this->last_attack = 0;
		$this->level = 6;
		$this->damage = 3;
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
			if($chance < 30)
			{
				$thisplayer->damage($this->damage, "melee");
			} else {
				parent::damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
			
			}
			parent::unset_radius($thisplayer);
		}
	}
}