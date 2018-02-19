<?php

class skullbringersAxe extends Weapon
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
	public function __construct()
	{
		$this->name = "Skullbringer's Axe";
		$this->color = "#ff8000";
		$this->id = "0035";
		$this->rarity = "legendary";
		$this->description = "The axe of Barynn the Skullbringer.";
		$this->radius_type = "cube";
		$this->radius_var_1 = 1;
		$this->radius_var_2 = 1;
		$this->level = 1;
		$this->damage = 10;
		$this->minprice = 3000;
		$this->maxprice = 10000;
	}

	public function use($thisplayer)
	{
		if($thisplayer->level >= $this->level)
		{
			parent::create_radius($thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2, $this->color);
		} else {
			status($this->clientid, "You need to be level " . $this->level . " to use \"<span style='color:".$this->color." !important;'>" . $this->name . "</span>\"" . ".");
		}
	}

	public function useRadius($thisplayer)
	{
		$this->damage_in_radius($this->damage, "melee", $thisplayer, $this->radius_type, $this->radius_var_1, $this->radius_var_2);
		parent::unset_radius($thisplayer);
	}

	public function damage_in_radius($damage, $damage_type, $thisplayer, $radius_type, $radius_var_1, $radius_var_2)
	{
		global $map;
			$ystart = $thisplayer->y + $radius_var_2;
			$yend = $thisplayer->y - $radius_var_2;
			$xstart = $thisplayer->x - $radius_var_1;
			$xend = $thisplayer->x + $radius_var_1;

			for ($i=$yend; $i <= $ystart; $i++) {
				$wall = false;
				$floor = false;
				for($ix = $xstart; $ix <= $xend; $ix++)
				{
					if($map[$ix][$i] != null)
					{
						if($map[$ix][$i]->type() == "player")
						{
							if($map[$ix][$i]->clientid != $thisplayer->clientid)
							{
								if($map[$ix][$i]->curshield == 0)
								{
									$map[$ix][$i]->damage(250, $damage_type, $thisplayer);
								} else {
									$map[$ix][$i]->damage($damage, $damage_type, $thisplayer);
								}
								
							}							
						} elseif($map[$ix][$i]->type() == "npc") {
							if($map[$ix][$i]->clientid != $thisplayer->clientid)
							{
								$map[$ix][$i]->damage($damage, $damage_type, $thisplayer);
							}
						}
					}
				}
				if(!$floor && $wall)
				{ // Some kind of raycasting has to be done, so it doesn't create radius on other side of wall.
					//$yend = $i;
				}
				$wall = false;
				$floor = false;
			}

	}

}