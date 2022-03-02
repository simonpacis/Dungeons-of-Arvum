<?php

class skullMan extends Mob
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
		$this->name = "B́arynn the Skullbringer";
		$this->basedamage = 35;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 300;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 10;
		$this->target = null;
		$this->range = 2;
		$this->viewrange = 15;
		$this->representation = "B́";
		$this->solid = true;
		$this->color = "#ff8000";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 1; // Squares per second.
		$this->attackspeed = 1; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = new skullArmor();
		$this->rarity = "legendary";
	}


}