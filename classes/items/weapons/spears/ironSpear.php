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
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->level = 3;
		$this->damage = 2;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
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