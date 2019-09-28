<?php

class longSword extends Weapon
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
		$this->name = "Longsword";
		$this->color = "#1eff00";
		$this->id = "0016";
		$this->rarity = "uncommon";
		$this->description = "A longer sword.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 2;
		$this->radius_var_2 = 2;
		$this->damage = 10;
		$this->damage_type = "melee";
		$this->level = 8;
	}

	public function use($thisplayer)
	{
		if($thisplayer->level >= $this->level)
		{
			parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
		} else {
			status($this->clientid, "You need to be level " . $this->level . " to use \"<span style='color:".$this->color." !important;'>" . $this->name . "</span>\"" . ".");
		}
	}

	public function useRadius($thisplayer)
	{
		parent::damage_in_radius(5, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
	}
}
