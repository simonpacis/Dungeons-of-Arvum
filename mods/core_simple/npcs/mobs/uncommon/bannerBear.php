<?php

class bannerBear extends Mob
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
		$this->name = "Banner Bear";
		$this->basedamage = 5;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 10;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 4;
		$this->target = null;
		$this->range = 1;
		$this->viewrange = 5;
		$this->representation = "B";
		$this->solid = true;
		$this->color = "#783f04";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 6; // Squares per second.
		$this->attackspeed = 0.1; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = getItem("common", "uncommon", false, true, 0.70);
		$this->rarity = "uncommon";
	}


}