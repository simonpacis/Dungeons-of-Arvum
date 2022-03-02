<?php

class shortBow extends Weapon
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
		$this->name = "Shortbow";
		$this->color = "#fff";
		$this->id = "0006";
		$this->rarity = "common";
		$this->description = "An ordinary bow that shoots arrows.";
		$this->maxuses = 7;
		$this->curuses = $this->maxuses;
		$this->radius_type = "cube";
		$this->radius_var_1 = 3;
		$this->radius_var_2 = 3;
		$this->attack_speed = 0.5;
		$this->damage = 2;
		$this->level = 1;
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