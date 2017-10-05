<?php

class brandistock extends Weapon
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
		$this->name = "Brandistock";
		$this->color = "#1eff00";
		$this->id = "0023";
		$this->rarity = "uncommon";
		$this->damage = 3;
		$this->description = "An ordinary brandistock. Has 30% chance to deal double damage, and 20% chance to single damage yourself. Damage: " . $this->damage;
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->level = 6;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		$chance = rand(1,100);
		if($chance < 50)
		{
			parent::damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		} elseif($chance >= 50 && $chance < 70) {
			$thisplayer->damage($this->damage, "melee");
		} else {
			parent::damage_in_radius(round($this->damage * 2), "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		
		}
		parent::unset_radius($thisplayer);
	}
}