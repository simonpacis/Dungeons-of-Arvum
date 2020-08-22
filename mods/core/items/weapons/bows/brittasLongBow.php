<?php

class brittasLongBow extends Weapon
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
		$this->name = "Britta's Longbow";
		$this->color = "#a335ee";
		$this->id = "0056";
		$this->rarity = "epic";
		$this->description = "A taller bow crafted by the masterful Britta.";
		$this->maxuses = 50;
		$this->curuses = $this->maxuses;
		$this->damage_type = "ranged";
		$this->damage = 10;
		$this->radius_type = "cube";
		$this->radius_var_1 = 8;
		$this->radius_var_2 = 8;
		$this->level = 13;
		$this->attack_speed = 0.5;
		parent::__construct();
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		parent::damage_in_radius($this->damage, "ranged", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
		return true;
	}
}
