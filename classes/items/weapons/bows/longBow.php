<?php

class longBow extends Weapon
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
		$this->name = "Longbow";
		$this->color = "#1eff00";
		$this->id = "0007";
		$this->rarity = "uncommon";
		$this->description = "A taller bow which shoots arrows further away.";
		$this->maxuses = 10;
		$this->curuses = $this->maxuses;
		$this->damage_type = "ranged";
		$this->radius_type = "cube";
		$this->radius_var_1 = 8;
		$this->radius_var_2 = 8;
		$this->level = 2;
		$this->minprice = 20;
		$this->maxprice = 40;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		parent::damage_in_radius(3, "ranged", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
		return true;
	}
}
