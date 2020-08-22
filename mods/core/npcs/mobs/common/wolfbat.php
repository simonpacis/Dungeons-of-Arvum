<?php

class wolfbat extends Mob
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
	public $movementspeed;

	public function __construct()
	{
		$this->name = "Cougarbat";
		$this->basedamage = 2;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 5;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 2;
		$this->target = null;
		$this->range = 1;
		$this->viewrange = 5;
		$this->representation = "C";
		$this->solid = true;
		$this->color = "#9900ff";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 10; // Squares per second.
		$this->attackspeed = 0.5; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = getItem("common","uncommon",false,true,0.6);
		$this->rarity = "common";
	}


}