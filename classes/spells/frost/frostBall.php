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
		$this->color = "#ffffff";
		$this->id = "0018";
		$this->rarity = "common";
		$this->description = "Slows enemies in radius 50% for 3 secs.";
		$this->damage_type = "magical";
		$this->panel_value = "50% slow, 3 secs";
		$this->radius_type = "cube";
		$this->radius_var_1 = 7;
		$this->radius_var_2 = 7;
		$this->level = 3;
		$this->mana_use = 5;
		$this->freeze_duration = 3;
		$this->dupe_level = 1;
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
		if($this->dupe_level < 4)
		{
			$this->dupe_level++;
		}
		if($this->dupe_level == 2)
		{
			$this->description = "Has 50% chance to freeze enemies for 3 secs.";
			$this->panel_value = "50% frz, 3 secs";
			$this->mana_use = 10;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 50% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Frostbolt";

		}
		if($this->dupe_level == 3)
		{
			$this->description = "Freezes enemies for 3 secs.";
			$this->panel_value = "100% frz, 3 secs";
			$this->mana_use = 25;
			if(!$notify)
			{
				status($thisplayer->clientid, "You obtained another " . $this->name . ". It now has a 100% chance to freeze enemies for 3 seconds.");
			}
			$this->name = "Frostblast";

		}

	}

	public function use($thisplayer)
	{
		parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
	}

	public function useRadius($thisplayer)
	{
		parent::freeze_in_radius(round($this->freeze_duration), $this->damage_type, $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, 50);
		parent::unset_radius($thisplayer);
		return true;
	}
}