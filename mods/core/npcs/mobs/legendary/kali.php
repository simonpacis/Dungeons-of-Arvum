<?php

class kali extends Mob
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
	public $attack_in_safe;

	public function __construct()
	{
		$this->name = "Kali the King of Thieves";
		$this->basedamage = 125;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 350;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 20;
		$this->target = null;
		$this->range = 3;
		$this->viewrange = 30;
		$this->representation = "K";
		$this->solid = true;
		$this->color = "#ff8000";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 3; // Squares per second.
		$this->attackspeed = 3; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = new amuletOfYendor();
		$this->rarity = "legendary";
		$this->attack_in_safe = true;
	}


}