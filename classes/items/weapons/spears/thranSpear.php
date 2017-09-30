<?php

class thranSpear extends Weapon
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
		$this->name = "Thran Spear";
		$this->color = "#0070ff";
		$this->id = "0022";
		$this->rarity = "strong";
		$this->description = "A spear from Thran. Has 20% chance to hit yourself.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->level = 7;
		$this->damage = 5;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		$chance = rand(1,100);
		if($chance < 80)
		{
			parent::damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		} else {
			$thisplayer->damage($this->damage, "melee");
		}
		parent::unset_radius($thisplayer);
	}
}