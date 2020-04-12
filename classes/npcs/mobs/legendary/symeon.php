<?php

class symeon extends Mob
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
		$this->name = "Symeon the Thunderwizard";
		$this->basedamage = 20;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 350;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 10;
		$this->target = null;
		$this->range = 2;
		$this->viewrange = 30;
		$this->representation = "S";
		$this->solid = true;
		$this->color = "#ff8000";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 1; // Squares per second.
		$this->attackspeed = 1.5; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = new portableWaypointTeleporter();
		$this->rarity = "legendary";
	}


}