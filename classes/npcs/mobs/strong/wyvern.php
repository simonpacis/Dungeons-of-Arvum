<?php

class wyvern extends Mob
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
		$this->name = "Wyvern";
		$this->basedamage = 4;
		$this->damage = $this->basedamage;
		$this->damage_type = "melee";
		$this->basehp = 12;
		$this->maxhp = $this->basehp;
		$this->curhp = $this->basehp;
		$this->level = 1;
		$this->target = null;
		$this->range = 1;
		$this->viewrange = 7;
		$this->representation = "W";
		$this->solid = true;
		$this->color = "#0000ff";
		$this->x = 0;
		$this->y = 0;
		$this->movementspeed = 6.75; // Squares per second.
		$this->attackspeed = 0.75; // Attacks per second.
		$this->lastmove = 0;
		$this->lastattack = 0;
		$this->loot = getItem("uncommon", "strong", false, true, 0.40);
		$this->rarity = "strong";
	}

	public function tick()
	{
		global $map;
		parent::move();
		if($this->target == null)
		{
			$this->target = parent::acquireTarget($this->x, $this->y, $this->viewrange, $map);
		}
	}

}