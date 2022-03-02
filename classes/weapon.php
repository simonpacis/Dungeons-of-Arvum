<?php

class Weapon extends Item
{
	public function __construct()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		parent::__construct();
	}

	public function dps()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if(isset($this->attack_speed))
		{
			return ((1/$this->attack_speed)*$this->damage);
		} else {
			return 0;
		}
	}

	public function create_radius($thisplayer, $radius_type, $radius_var_1, $radius_var_2, $color = "#fff")
	{
		global $map;
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if($radius_type == "cube")
		{
			$thisplayer->radius = true;
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
						if($map[$ix][$i]->representation() != "@")
						{
							if($map[$ix][$i]->representation() != "#") {
								$floor = true;
								$map[$ix][$i]->setColor($thisplayer->clientid, $color);	
								$thisplayer->radiustiles[$ix][$i] = "true";

							} else {
								$wall = true;
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

	public function can_attack($weapon, $thisplayer, $set_new_time = true)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if($thisplayer->level >= $weapon->level)
		{
			if(isset($weapon->attack_speed))
			{
				$curtime = round(microtime(true) * 1000);
				$attackspeed = $weapon->attack_speed * 1000;
				if($weapon->last_attack == 0 or ($curtime - $weapon->last_attack) >= $attackspeed)
				{
					if(!$thisplayer->isSafe())
					{
						if($set_new_time)
						{
							$weapon->last_attack = $curtime;
						}
						return true;
					} else {
						status($thisplayer->clientid, "You cannot attack when you're in a saferoom.");
						return false;
						
					}
				}
			} else {
				if(!$thisplayer->isSafe())
				{
					return true;
				} else {
					status($thisplayer->clientid, "You cannot attack when you're in a saferoom.");
					return false;
					
				}
			}
		} else {
			status($thisplayer->clientid, "You need to be level " . $weapon->level . " to use \"<span style='color:".$weapon->color." !important;'>" . $weapon->name . "</span>\"" . ".");

		}
	}

	public function damage_in_radius($damage, $damage_type, $thisplayer, $radius_type, $radius_var_1, $radius_var_2)
	{
		global $map;
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
			$ystart = $thisplayer->y + $radius_var_2;
			$yend = $thisplayer->y - $radius_var_2;
			$xstart = $thisplayer->x - $radius_var_1;
			$xend = $thisplayer->x + $radius_var_1;
			if($thisplayer->curstamina > 0)
			{
				
				for ($i=$yend; $i <= $ystart; $i++) {
					$wall = false;
					$floor = false;
					for($ix = $xstart; $ix <= $xend; $ix++)
					{
						if($map[$ix][$i] != null)
						{
							if($map[$ix][$i]->type() == "player" or $map[$ix][$i]->type() == "npc")
							{
								if($map[$ix][$i]->clientid != $thisplayer->clientid)
								{
									if(!$map[$ix][$i]->isSafe())
									{
										$map[$ix][$i]->damage($damage, $damage_type, $thisplayer);
									} else {
										status($thisplayer->clientid, $map[$ix][$i]->name . " were not damaged because they are in a saferoom.");
										
									}
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
				$thisplayer->curstamina--;
			}

	}

	public function created($thisplayer)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		return true;
	}

	public function unset_radius($thisplayer)
	{
		global $players;
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$player = $players[$thisplayer->clientid];
		$player->unsetTiles();
		$player->radius = false;
		$player->usedItem = null;
		bigBroadcast();
	}
}
