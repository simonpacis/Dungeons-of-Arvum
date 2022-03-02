<?php

class frostBall extends Spell
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
	public $freeze_duration;
	public function __construct()
	{
		$this->name = "Frostball";
		$this->color = "#42eef4";
		$this->id = "0018";
		$this->rarity = "common";
		$this->description = "Slows enemies in radius 50% for 3 secs. Range of 7.";
		$this->damage = 3;
		$this->damage_type = "magical ice";
		$this->panel_value = "slow by 50%, 3 secs";
		$this->radius_type = "cube";
		$this->radius_var_1 = 7;
		$this->radius_var_2 = 7;
		$this->level = 1;
		$this->mana_use = 5;
		$this->freeze_duration = 3;
		$this->dupe_level = 1;
		$this->chance = 50;
	}

	public function panelValue()
	{
		return [$this->panel_value, "#42eef4"];
	}

	public function describe($clientid)
	{
		status($clientid, "<span style='color:".$this->color." !important;'>" . $this->name . "</span>: " .$this->description . " Rarity: " . ucfirst($this->rarity) . ". Level: " . $this->level . ".", "#ffff00");			
		
		return true;
	}

	public function duplicate($thisplayer, $notify = true)
	{
		if($this->dupe_level < 5)
		{
			$this->dupe_level++;
		}
		if($this->dupe_level == 2)
		{
			$this->description = "Has 50% chance to freeze enemies for 3 secs.  Range of 7.";
			$this->panel_value = "frz, 3 secs";
			$this->mana_use = 10;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 50% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Frostblast";

		}
		if($this->dupe_level == 3)
		{
			$this->description = "Freezes enemies for 3 secs and damages them 3.  Range of 8.";
			$this->panel_value = "frz, 3 secs, dmg 3";
			$this->radius_var_1 = 9;
			$this->radius_var_2 = 9;
			$this->mana_use = 25;
			$this->chance = 100;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 100% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Frostwind";

		}
		if($this->dupe_level == 4)
		{
			$this->description = "Freezes enemies for 3 secs. Range of 9";
			$this->panel_value = "frz, 3 secs";
			$this->mana_use = 25;
			$this->chance = 100;
			$this->radius_var_1 = 10;
			$this->radius_var_2 = 10;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 100% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Frostitude";

		}
		if($this->dupe_level == 5)
		{
			$this->description = "Freezes enemies for 3 secs. Range of 12";
			$this->panel_value = "frz, 3 secs";
			$this->mana_use = 40;
			$this->radius_var_1 = 12;
			$this->radius_var_2 = 12;
			$this->chance = 100;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 100% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Glacier";

		}

	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		if($this->dupe_level == 1)
		{
			parent::do_in_radius("slow", [round($this->freeze_duration), 50, $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);			
		} else if($this->dupe_level == 2)
		{
			parent::do_in_radius("freeze", [round($this->freeze_duration), $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);			
		} else {
			parent::do_in_radius("freeze", [round($this->freeze_duration), $thisplayer], 100, $thisplayer, $this->
				radius_type, $this->radius_var_1, $this->radius_var_2);	
			parent::do_in_radius("damage", [round($this->damage), $this->damage_type, $thisplayer], 100, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		}
		parent::unset_radius($thisplayer);
		return true;
	}
}