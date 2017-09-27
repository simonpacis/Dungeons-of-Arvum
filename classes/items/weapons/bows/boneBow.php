<?php

class boneBow extends Weapon
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
		$this->name = "Bonebow";
		$this->color = "#a335ee";
		$this->id = "0020";
		$this->rarity = "epic";
		$this->description = "A bow made of human bones. Has 25% chance to damage yourself instead.";
		$this->maxuses = 25;
		$this->curuses = $this->maxuses;
		$this->damage_type = "ranged";
		$this->radius_type = "cube";
		$this->radius_var_1 = 12;
		$this->radius_var_2 = 8;
		$this->level = 7;
		$this->damage = 10;
	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		$rand = rand(1,100);
		if($rand <= 25)
		{
			$thisplayer->damage($this->damage, "ranged");
		} else {
			parent::damage_in_radius($this->damage, "ranged", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		}
		parent::unset_radius($thisplayer);
		return true;
	}
}