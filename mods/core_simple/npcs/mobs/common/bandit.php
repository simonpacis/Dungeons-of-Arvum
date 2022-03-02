<?php

class Bandit extends Mob
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
		$this->name = "Thief";
		$this->basedamage = 1;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 5;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 1;
		$this->target = null;
		$this->range = 1;
		$this->viewrange = 5;
		$this->representation = "T";
		$this->solid = true;
		$this->color = "#00ff00";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 3; // Squares per second.
		$this->attackspeed = 1; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = getItem("common","common",false,true,0.8);
		$this->rarity = "common";
	}


}