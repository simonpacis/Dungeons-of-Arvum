<?php

class mage extends Mob
{
	public $name;
	public $basedamage;
	public $basehp;
	public $maxhp;
	public $curhp;
	public $level;
	public $target;
	public $range;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $type;
	public $viewrange;
	public $lastmove;
	public $loot;
	public $rarity;

	public function __construct()
	{
		$this->name = "Mage";
		$this->basedamage = 1;
		$this->damage = $this->basedamage;
		$this->damage_type = "magical";
		$this->attack_type = "burn";
		$this->burn_damage = 1;
		$this->burn_duration = 6;
		$this->burn_frequency = 2;
		$this->basehp = 8;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 1;
		$this->target = null;
		$this->range = 4;
		$this->viewrange = 5;
		$this->representation = "M";
		$this->solid = true;
		$this->color = "#00ff00";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 3; // Squares per second.
		$this->attackspeed = 0.1; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = getItem("common","common",false,true,0.8);
		$this->rarity = "common";
	}

	public function levelUp()
	{
		parent::levelUp();
		if($this->basedamage < 3 && $this->level < 10)
		{
			$additionaldmg = round((($this->basedamage/5)*($this->level/3))*(0.3*$this->level));
		} else {
			$additionaldmg = round(($this->basedamage/5)*(0.2*$this->level));
		}
		$this->burn_damage = $this->burn_damage + $additionaldmg;	
	}


}