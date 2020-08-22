<?php

class lightningBall extends Spell
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
	public $mana_use;
	public $basestamina;
	public $stamina;
	public $basehp;
	public $hp;
	public $duration;
	public $baseduration;

	public function __construct()
	{
		$this->name = "Lightning Shield";
		$this->color = "#FDD023";
		$this->id = "0037";
		$this->rarity = "common";
		$this->description = "Empower yourself through the magic of lightning.";
		$this->damage_type = "magical";
		$this->radius_type = "cube";
		$this->radius_var_1 = 5;
		$this->radius_var_2 = 5;
		$this->level = 1;
		$this->basemanause = 5;
		$this->mana_use = 5;
		$this->damage = 3;
		$this->basestamina = 2;
		$this->stamina = $this->basestamina;
		$this->basehp = 5;
		$this->hp = $this->basehp;
		$this->baseduration = 10;
		$this->duration = $this->baseduration;
		$this->panel_value = "+" . $this->stamina . "sta, +". $this->hp ."hp, for ". $this->duration ."s";
	}

	public function panelValue()
	{
		return [$this->panel_value, "#FDD023"];
	}

	public function describe($clientid)
	{
		status($clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . ". Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");
		return true;
	}

	public function duplicate($thisplayer, $notify = true)
	{
		$this->level++;
		$this->hp = $this->basehp * (($this->level - 1)*2);
		$this->stamina = $this->basestamina * ($this->level - 1);
		$this->duration = $this->baseduration + ($this->baseduration * round((($this->level - 1)*0.2)));
		$this->mana_use = round($this->basemanause * ($this->level - 1));
		if(!$notify)
		{
			status($thisplayer->clientid, "You obtained another " . $this->name . ", which increased the damage to " . round($this->damage) . ", and the mana usage to " . $this->mana_use . ".");
		}
		$this->panel_value = "+" . $this->stamina . "sta, +". $this->hp ."hp, for ". $this->duration ."s";
		return true;
	}

	public function charmTick($thisplayer)
	{
		$curtime = round(microtime(true) * 1000);		
		$this->panel_value = "+sta " . $this->stamina . ", +hp ". $this->hp .", ". round((($thisplayer->charm_time+($thisplayer->charm_duration*1000)) - $curtime)/1000) ."s left";
	}

	public function charm($thisplayer)
	{
		$thisplayer->maxhp = $thisplayer->maxhp + $this->hp;
		$thisplayer->curhp = $thisplayer->curhp + $this->hp;
		$thisplayer->maxstamina = $thisplayer->maxstamina + $this->stamina;
		$thisplayer->curstamina = $thisplayer->curstamina + $this->stamina;
		return true;
	}

	public function uncharm($thisplayer)
	{
		$thisplayer->maxhp = $thisplayer->maxhp - $this->hp;
		$thisplayer->curhp = $thisplayer->curhp - $this->hp;
		$thisplayer->maxstamina = $thisplayer->maxstamina - $this->stamina;
		$thisplayer->curstamina = $thisplayer->curstamina - $this->stamina;
		$this->panel_value = "+sta " . $this->stamina . ", +hp ". $this->hp .", for ". $this->duration ."s";
		return true;
	}


	public function use($thisplayer)
	{
		$thisplayer->charm($this, $this->duration);
		return true;
	}

	public function useRadius($thisplayer)
	{
		//parent::do_in_radius("damage", [round($this->damage), $this->damage_type, $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::do_in_radius("burn", [ceil($this->damage/3), $this->burn_duration, $this->burn_frequency, $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
		return true;
	}
}