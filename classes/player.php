<?php

class Player
{
	public $clientid;
	public $name;
	public $level;
	public $curhp;
	public $maxhp;
	public $curshield;
	public $maxshield;
	public $curmana;
	public $maxmana;
	public $curxp;
	public $maxxp;
	public $x;
	public $y;
	public $solid;
	public $representation;
	public $color;
	public $inventory;
	public $spells;
	public $hold;
	public $force_hold;
	public $requestVar;
	public $requestArg;
	public $cheats;
	public $ready;
	public $state;
	public $hardcheats;
	public $dead;
	public $radiustiles;
	public $radius;
	public $usedItem;
	public $usedSpell;
	public $wieldedArmor;
	public $healthpots;
	public $manapots;
	public $last_timeout;
	public $in_timeout;
	public $curtimeout;
	public $maxtimeout;
	public $auto_timeout;
	public $show_settings;
	public $selected_setting;
	public $max_settings;
	public $used_auto_timeout;
	public $timeout_started_at;
	public $mana_regen;
	public $last_mana_regen;
	public $hp_regen;
	public $last_hp_regen;
	public $stamina_regen;
	public $last_stamina_regen;
	public $describe_function;
	public $on_tile;
	public $coins;
	public $waypoint_x;
	public $waypoint_y;
	public $in_shop;
	public $action_text;
	public $action_target;
	public $movementspeed;
	public $currentmovementspeed;
	public $lastmove;
	public $userid;
	public $characterid;
	public $burned;
	public $burn_damage;
	public $burn_frequency;
	public $burn_duration;
	public $last_burn;
	public $first_burn;
	public $burn_player;
	public $is_burn_player;
	public $invincible;
	public $invincible_duration;
	public $last_invincible;
	public $first_invincible;
	public $legendary_kills;
	public $lowest_level_bonus;
	public $frozen;
	public $frozen_duration;
	public $frozen_time;
	public $slowmovementspeed;
	public $slowed_at;
	public $slow_for;
	public $slowed;
	public $slowmaxstamina;
	public $keybindings;
	public $charmed;
	public $charm;
	public $charm_duration;
	public $charm_time;
	public $first_charm;

	public function __construct($Clientid)
	{
		global $default_auto_timeout, $keybindings;
		$this->clientid = $Clientid;
		$this->name = "null";
		$this->level = 1;
		$this->curhp = 20;
		$this->maxhp = 20;
		$this->curshield = 0;
		$this->maxshield = 10;
		$this->curmana = 20;
		$this->maxmana = 20;
		$this->curxp = 0;
		$this->maxxp = 14;
		$this->maxstamina = 10;
		$this->curstamina = $this->maxstamina;
		$this->x = 0;
		$this->y = 0;
		$this->solid = true;
		$this->representation = "@";
		$this->color = "#ffff00";
		$this->inventory = [];
		$this->spells = [];
		$this->cheats = false;
		$this->hardcheats = false;
		$this->hold = false;
		$this->force_hold = false;
		$this->ready = false;
		$this->state = "noname";
		$this->requestVar = null;
		$this->requestArg = null;
		$this->dead = false;
		$this->radiustiles = [];
		$this->radius = false;
		$this->usedItem = null;
		$this->usedSpell = null;
		$this->wieldedArmor = null;
		$this->healthpots = 1;
		$this->manapots = 1;
		$this->last_timeout = 0;
		$this->in_timeout = false;
		$this->curtimeout = 3;
		$this->maxtimeout = 3;
		if($default_auto_timeout != -1)
		{
			$this->auto_timeout = $default_auto_timeout;
		} else {
			$this->auto_timeout = 0;
		}
		$this->show_settings = false;
		$this->selected_setting = 0;
		$this->max_settings = 1;
		$this->used_auto_timeout = false;
		$this->timeout_started_at = 0;
		$this->mana_regen = 0.30; //Mana regenerated per second;
		$this->last_mana_regen = 0;
		$this->hp_regen = 0.15; //HP regenerated per second;
		$this->last_hp_regen = 0;
		$this->stamina_regen = 75; //Microseconds pr. stamina regenerated
		$this->last_stamina_regen = 0;
		$this->describe_function = false;
		$this->on_tile = null;
		$this->coins = 0;
		$this->waypoint_x = -1;
		$this->waypoint_y = -1;
		$this->in_shop = false;
		$this->action_text = "(No action)";
		$this->action_target = null;
		$this->movementspeed = 6;
		$this->currentmovementspeed = $this->movementspeed;
		$this->userid = 0;
		$this->characterid = 0;
		$this->lastmove = 0;
		$this->burned = false;
		$this->burn_damage = 0;
		$this->burn_frequency = 0;
		$this->burn_duration = 0;
		$this->last_burn = 0;
		$this->first_burn = 0;
		$this->burn_player = null;
		$this->is_burn_player = false;
		$this->invincible = false;
		$this->invincible_duration = 0;
		$this->last_invincible = 0;
		$this->first_invincible = 0;
		$this->legendary_kills = 0;
		$this->lowest_level_bonus = 1;
		$this->frozen = false;
		$this->frozen_duration = 0;
		$this->frozen_time = 0;
		$this->slowed = false;
		$this->slowmovementspeed = 0;
		$this->slowmaxstamina = 0;
		$this->slowed_at = 0;
		$this->slow_for = 0;
		$this->keybindings = $keybindings;
		$this->charmed = false;
		$this->charm = null;
		$this->charm_duration = 0;
		$this->charm_time = 0;
		$this->first_charm = 0;
	}

	public function parseKeybindings()
	{
		return $this->keybindings;
	}

	public function updateKeybindings($keybindings)
	{
		$this->keybindings = $keybindings;
		return true;
	}

	public function updateKeybinding($key, $newkey)
	{
		$this->keybindings[$key] = $newkey;
		return true;
	}

	public function getKeybinding($key)
	{
		return str_replace("VK_", "", $this->keybindings[$key]);
	}

	public function tick()
	{
		if($this->burned)
		{
			$this->performBurn();
		}
		if($this->invincible)
		{
			$this->performInvincible();
		}
		if($this->charmed)
		{
			$this->performCharm();
		}
		if($this->slowed)
		{
			$this->maxstamina = $this->slowmaxstamina;
			if(($this->slowed_at + $this->slow_for) <= microtime(true))
			{
				$this->unSlow();
			}
		}
	}

	public function move($x_veloc = 0, $y_veloc = 0)
	{

		global $enable_player_movement_speed;

		$this->currentmovementspeed = $this->movementspeed;

		if($enable_player_movement_speed)
		{
			$allowed_to_move = false;
			$seconds_per_square = 1000/$this->currentmovementspeed;
			$curtime = round(microtime(true) * 1000);
			if($this->lastmove == 0 or ($curtime - $this->lastmove) >= $seconds_per_square)
			{
				$allowed_to_move = true;
				$this->lastmove = round(microtime(true) * 1000);
			} else {
				$allowed_to_move = false;
			}
		} else {
			if($this->curstamina > 0)
			{
				$allowed_to_move = true;
			}
		}


		if(!$this->isFrozen())
		{
			if($allowed_to_move)
			{
				if(!$this->hold && !$this->radius && !$this->force_hold)
				{
					if(movePlayerTile($this->x, $this->y, ($this->x + $x_veloc), ($this->y + $y_veloc), $this)){
						$this->x = $this->x + $x_veloc;
						$this->y = $this->y + $y_veloc;


						if($this->hasHook("before_stamina_use"))
						{
							$this->runHook("before_stamina_use", $this);
						}

						$this->curstamina--;
						$check_for_action = $this->checkForAction();

						if($check_for_action['relevant'] == true)
						{
							$this->action_text = ($check_for_action['object']->object->action_text);
							$this->action_target = $check_for_action['object']->object;
						} else {
							$this->unsetActionTarget();
						}
					}
				}
			}
		} else {
			status($this->clientid, "You're frozen and cannot move.", "#42eef4");

		}

	}

	public function unsetActionTarget()
	{
		$this->action_text = "(No action)";
		$this->action_target = null;
	}

	public function checkForAction()
	{
		global $map;
		$ystart = $this->y + 1;
		$yend = $this->y - 1;
		$xstart = $this->x - 1;
		$xend = $this->x + 1;

		for ($i=$yend; $i <= $ystart; $i++) {
			for($ix = $xstart; $ix <= $xend; $ix++)
			{
				if($map[$ix][$i] != null)
				{
					if($map[$ix][$i]->type() == "character")
					{
						return ["relevant" => true, "object" => $map[$ix][$i]];
					}
				}
			}
		}
		return ["relevant" => false];
	}

	public function killed($enemy)
	{
		global $vacant_rooms, $single_player_mode;
		if($this->hasHook("after_kill"))
		{
			$this->runHook("after_kill", $enemy, $this);
		}
		$random = rand(0,100);
		if($random > 50)
		{
			$this->coins += floor(($enemy->damage + ($enemy->basehp/1.3) + (pow($enemy->level,1.2))));
		}
		$exp = $enemy->damage + ($enemy->basehp/1.3) + (pow($enemy->level,1.3));
		$this->gainExp($exp);

		if($single_player_mode)
		{
			if($enemy->rarity == "legendary")
			{
				$this->legendary_kills++;
				if($this->legendary_kills == 3)
				{
					$room = $vacant_rooms[array_rand($vacant_rooms, 1)];
					$xcoord = rand($room["_x1"], $room["_x2"]);
					$ycoord = rand($room["_y1"], $room["_y2"]);
					spawnMob(new kali(), $xcoord, $ycoord);
					status($this->clientid, "Kali the King of Thieves has been spawned! Kill him to win the game.", "#ff33cc");
				}
			}
		}
	}

	public function gainExp($exp)
	{
		if($this->hasHook("before_gain_exp"))
		{
			$exp = $this->runHook("before_gain_exp", $this);
		}
		$exp = $exp * $this->lowest_level_bonus;
		$this->curxp = $this->curxp + floor($exp);
		if($this->curxp >= $this->maxxp)
		{
			$this->levelUp();
		}
		if($this->hasHook("after_gain_exp"))
		{
			$this->runHook("after_gain_exp", $this);
		}
	}
	public function levelUp()
	{
		global $players, $mobs;
		$this->level++;
		phonehome($this);
		if($this->level % 10 == 0) //Every tenth level, suspensions are reset.
		{
			$this->curtimeout = $this->maxtimeout;
		}
		// Calc new maxhp.
		$additionalhp = round(pow(($this->level-1),1.4));
		$this->maxhp = $this->maxhp + $additionalhp;
		$additionalshield = 10;
		$this->maxshield = $this->maxshield + $additionalshield;
		if($this->curhp < round($this->maxhp/2))
		{
			$this->curhp = round($this->maxhp/2);
		}
		if($this->curhp > $this->maxhp)
		{
			$this->curhp = $this->maxhp;
		}
		$additionalmana = round(pow(($this->level-1),1.10));
		$this->maxmana = $this->maxmana + $additionalmana;
		$this->curmana = $this->maxmana;
		if($this->curhp > $this->auto_timeout)
		{
			$this->used_auto_timeout = false;
		}
		if($this->hasHook("mana_increase"))
		{
			$this->runHook("mana_increase", $this);
		}
		$highestlvl = $this->level;
		$lowestlvl = $this->level;
		foreach($players as $curplayer)
		{
			if($curplayer->name == "___tick")
			{
				continue;
			}
			if($curplayer->level > $highestlvl)
			{
				$highestlvl = $curplayer->level;
			}
			if($curplayer->level < $lowestlvl)
			{

				$lowestlvl = $curplayer->level;
			}
			$curplayer->lowest_level_bonus = 1;
		}

		if($highestlvl == $this->level)
		{
			$i = 0;
			foreach($mobs as $curmob)
			{
				if($curmob->target == null && $curmob->level < $this->level) // Not in combat
				{
					$should_levelup = rand(0, 100);
					if($should_levelup < 90)
					{

						$curmob->levelUp();
					}
					$i++;
				}
			}
		}
		status($this->clientid, "You've gained a level!", "#ff33cc");
		statusBroadcast($this->name . " reached level " . $this->level . "!", "#ff33cc", false, $this->clientid);
		foreach($players as $curplayer)
		{
			if($curplayer->name == "___tick")
			{
				continue;
			}
			if($lowestlvl < $highestlvl)
			{
				if($curplayer->level == $lowestlvl)
				{
					status($curplayer->clientid, "You're the lowest leveled player. Receive 20% XP bonus.", "#ff33cc");
					$curplayer->lowest_level_bonus = 1.2;
				}
			}

		}
		

		$a=0;
		  for($x=1; $x<($this->level+1); $x++) {
		    $a += floor($x+80*pow(2, ($x/7)));
		}
		$this->maxxp = floor($a/4);
	}

	public function regenerate()
	{
		if($this->last_mana_regen == 0)
		{
			$this->last_mana_regen = time();
			$this->last_hp_regen = time();
			$this->last_stamina_regen = round(microtime(true) * 1000);
		}

		$seconds_per_mana = round(1/$this->mana_regen);
		if(($this->last_mana_regen+$seconds_per_mana) <= time())
		{
			if($this->curmana < $this->maxmana)
			{
				$this->curmana++;
			}
			$this->last_mana_regen = time();
		}


		if($this->hasHook("before_stamina_regen"))
		{
			$stamina_regen = $this->runHook("before_stamina_regen", $this->stamina_regen, $this);
		} else {
			$stamina_regen = $this->stamina_regen;
		}
		if(($this->last_stamina_regen+$stamina_regen) <= round(microtime(true) * 1000))
		{
			$passed = (round(microtime(true) * 1000) - ($this->last_stamina_regen+$stamina_regen));
			$amount_of_passed = round($passed/$stamina_regen);
			for($i = 0; $i < $amount_of_passed; $i++)
			{
				if($this->curstamina < $this->maxstamina)
				{
					$this->curstamina++;
				}				
			}
			$this->last_stamina_regen = round(microtime(true) * 1000);
		}
		$seconds_per_hp = round(1/$this->hp_regen);
		if(($this->last_hp_regen+$seconds_per_hp) <= time())
		{
			if($this->curhp < $this->maxhp)
			{
				$this->curhp++;
			}
			$this->last_hp_regen = time();
		}
	}

	public function inTimeout()
	{
		global $default_timeout_duration;
		if($this->in_timeout)
		{
			if(($this->last_timeout + $default_timeout_duration) <= time()) //Time has passed.
			{
				$this->in_timeout = false;
				$this->force_hold = false;
				$this->timeout_started_at = round(microtime(true) * 1000);
				status($this->clientid, "You've been unsuspended.", "#ff33cc");
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
		
	}

	public function unsetTimeout()
	{
		$this->in_timeout = false;
		$this->force_hold = false;
		status($this->clientid, "You've been unsuspended.", "#ff33cc");
	}

	public function setTimeout()
	{
		global $default_auto_timeout, $default_timeout_duration;
		if($default_auto_timeout != -1)
		{
			if(!$this->in_timeout && $this->curtimeout > 0 && $this->state == "game")
			{
				$this->force_hold = true;
				$this->in_timeout = true;
				$this->last_timeout = time();
				$this->curtimeout--;
				status($this->clientid, "You're magically suspended for " . $default_timeout_duration . " seconds.", "#ff33cc");
				return true;
			} else {
				status($this->clientid, "You have no more suspensions to use.");
				return false;
			}
		}
	}

	public function addHealthpot($amount = 1, $healthpot)
	{
		$this->healthpots = $this->healthpots + $amount;
		if($amount != 1)
		{
			status($this->clientid, "You picked up ".$amount." \"<span style='color:#5CCC6B !important;'>Health Potions</span>\".", "#ffff00");
		} else {
			status($this->clientid, "You picked up a \"<span style='color:#5CCC6B !important;'>Health Potion</span>\".", "#ffff00");
		}
		unset($healthpot);
		return true;
	}

	public function useHealthpot()
	{
		if($this->healthpots > 0 && $this->curhp != $this->maxhp)
		{
			$this->heal(round($this->maxhp*0.2));
			$this->healthpots = $this->healthpots - 1;
			return true;
		} elseif($this->healthpots == 0 && $this->curhp != $this->maxhp) {
			status($this->clientid, "You do not have any \"<span style='color:#5CCC6B !important;'>Health Potions</span>\".", "#ffff00");
			return false;
		} elseif($this->curhp == $this->maxhp)
		{
			status($this->clientid, "You do not need to use a \"<span style='color:#5CCC6B !important;'>Health Potion</span>\".", "#ffff00");
			return false;
		}
	}

	public function addManapot($amount = 1, $manapot)
	{
		$this->manapots = $this->manapots + $amount;
		if($amount != 1)
		{
			status($this->clientid, "You picked up ".$amount." \"<span style='color:#6495ED !important;'>Mana Potions</span>\".", "#ffff00");
		} else {
			status($this->clientid, "You picked up a \"<span style='color:#6495ED !important;'>Mana Potion</span>\".", "#ffff00");
		}
		unset($manapot);
		return true;
	}

	public function useManapot()
	{
		if($this->curmana == $this->maxmana && $this->manapots != 0)
		{
			status($this->clientid, "You do not need to use a \"<span style='color:#6495ED !important;'>Mana Potion</span>\".", "#ffff00");
			return false;
		}elseif($this->manapots > 0 && $this->maxmana != $this->curmana)
		{
			$this->addMana(5);
			$this->manapots = $this->manapots - 1;
			return true;
		} elseif($this->manapots == 0) {
			status($this->clientid, "You do not have any \"<span style='color:#6495ED !important;'>Mana Potions</span>\".", "#ffff00");
			return false;
		}
	}

	public function type()
	{
		return "player";
	}

	public function representation()
	{
		return $this->representation;
	}

	public function color()
	{
		return $this->color;
	}

	public function solid()
	{
		return $this->solid;
	}

	public function parse()
	{
		global $enable_player_movement_speed;
		if($this->waypoint_x < 0)
		{
			$waypoint_x = 0;
			$waypoint_y = 0;
		} else {
			$waypoint_x = ($this->x - $this->waypoint_x);
			$waypoint_y = ($this->waypoint_y - $this->y);
		}
		if($this->curhp <= ($this->maxhp/4))
		{
			$curhp = "<span style='color:#ff5c5c;'>" . $this->curhp . "</span>";
		} else {
			$curhp = "<span style='color:#5CCC6B;'>" . $this->curhp . "</span>";
		}
		$maxhp = $this->maxhp;

		if($this->invincible)
		{
			if($this->first_invincible != 0)
			{
				$curhp = "<span style='color:#00ff00;'>".round((($this->first_invincible + ($this->invincible_duration*1000)) - (round(microtime(true)*1000)))/1000)."sec</span>";
			} else {
				$curhp = "<span style='color:#00ff00;'>".$this->invincible_duration."sec</span>";
			}
			$maxhp = "<span style='color:#00ff00;'>∞</span>";

		}

		if($enable_player_movement_speed)
		{
			$movementspeed = $this->currentmovementspeed;
		} else {
			$movementspeed = "Not enabled";
		}

		if($this->maxstamina < 20)
		{
			$stamina = "";

			for($i = 0; $i < $this->curstamina; $i++)
			{
				$stamina .= "<span style='color:#00ff00;'>|</span>";
			}

			if($this->curstamina < $this->maxstamina)
			{
				for($i = 0; $i < ($this->maxstamina - $this->curstamina); $i++)
				{
					$stamina .= "<span style='color:#ff0000;'>|</span>";
				}
			}
		} else {
			$stamina = $this->curstamina."/".$this->maxstamina;
		}

		if($this->lowest_level_bonus > 1)
		{
			$xp_bonus = " (" . (($this->lowest_level_bonus-1)*100) . "%)";
		} else {
			$xp_bonus = "";
		}

		return ["name" => $this->name, "curhp" => $curhp, "maxhp" => $maxhp, "curmana" => $this->curmana, "maxmana" => $this->maxmana, "curxp" => $this->curxp, "maxxp" => $this->maxxp, "level" => $this->level, "inventory" => $this->parseInventory(), "spells" => $this->parseSpells(), "x" => $this->x, "y" => $this->y, "armor" => $this->parseArmor(), "healthpots" => $this->healthpots, "manapots" => $this->manapots, "curtimeout" => $this->curtimeout, "maxtimeout" => $this->maxtimeout, "coins" => "<span style='color: #ffd700 !important;'>" . $this->coins . "</span>", "waypoint_x" => $waypoint_x, "waypoint_y" => $waypoint_y, "action_text" => $this->action_text, "movement_speed" => $movementspeed, "curshield" => $this->curshield, "maxshield" => $this->maxshield, "stamina" => $stamina, "xp_bonus" => $xp_bonus];
	}

	public function setWaypoint()
	{
		status($this->clientid, "Waypoint set.");
		$this->waypoint_x = $this->x;
		$this->waypoint_y = $this->y;
	}


	public function isSafe()
	{
		global $safe_rooms;
		foreach ($safe_rooms as $room)
		{
			if($this->x >= $room['_x1'] && $this->x <= $room['_x2'] && $this->y >= $room['_y1'] && $this->y <= $room['_y2'])
			{
				return true;
			}
		}
		return false;
	}

	public function parseArmor()
	{
		if($this->wieldedArmor != null)
		{
			$arm = [];
			$arm["color"] = $this->wieldedArmor->color;
			if(isset($this->wieldedArmor->maxuses))
			{
				$arm["name"] = $this->wieldedArmor->name . " (".$this->wieldedArmor->curuses . " left)";
			} else {
				$arm["name"] = $this->wieldedArmor->name;
			}
			return $arm;
		} else {
			$arm = [];
			$arm["name"] = "(empty)";
			$arm["color"] = "#fff";
			return $arm;
		}
	}

	public function addCoins($coins, $notify = true)
	{
		$this->coins = $this->coins + $coins;
		if($notify)
		{
			status($this->clientid, "You gained " . $coins . " coins.", "#ffff00");
		}

	}

	public function addToInventory($item, $faux = false, $notify = true, $send_to_server = true)
	{
		global $massive;
		$invcount = count($this->inventory);
		foreach($this->inventory as $invitem)
		{
			if($item->id == $invitem->id && isset($item->maxuses) && !isset($item->wield_type))
			{
				$invitem->maxuses = $invitem->maxuses + $item->maxuses;
				$invitem->curuses = $invitem->curuses + $item->curuses;
				if($notify)
				{
					status($this->clientid, "You picked up another \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\", which added " . $item->curuses . " more uses.", "#ffff00");
				}
				return true;
			}
		}
		$item = clone $item;
		if($invcount < 9 OR $faux == true)
		{
			if($faux == false)
			{
				array_push($this->inventory, $item);
			}
			if($notify) {
				status($this->clientid, "\"" . $item->description . "\"");
				status($this->clientid, "You picked up \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".", "#ffff00");
			}
			if($item->rarity == "legendary")
			{
				if($notify) {
					statusBroadcast($this->name . " picked up \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"!", "#ffff00", false, $this->clientid);
				}
			}
			if($massive)
			{
				newInventoryMassive($item, $this);
			}
		} else {
			$this->request('inventoryFull', $item);
		}
	}

	public function escape()
	{
		$this->unsetRequest();
		$this->unsetTiles();
		$this->usedItem = null;
		$this->radius = null;
		$this->show_settings = false;
		$this->in_shop = false;
		return true;
	}

	public function wield($item, $type)
	{
		$uctype = ucfirst($type);
		if($this->level >= $item->level)
		{
			if($this->{"wielded".$uctype} != null && $this->{"wielded".$uctype} != $item)
			{
				$oldwield = $this->{"wielded".$uctype}->name;
				$oldwieldcolor = $this->{"wielded".$uctype}->color;
				$this->unwield($this->{"wielded".$uctype}, $this->{"wielded".$uctype}->wield_type);
				$this->{"wielded".$uctype} = $item;
				$this->{"wielded".$uctype}->wielded = true;
				status($this->clientid, "You unwielded \"<span style='color:".$oldwieldcolor." !important;'>" . $oldwield . "</span>\" and wielded \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\" instead.");
			} elseif($this->{"wielded".$uctype} == $item) {
				status($this->clientid, "You unwielded \"<span style='color:".$this->{"wielded".$uctype}->color." !important;'>" . $this->{"wielded".$uctype}->name . "</span>\".");
				$this->unwield($this->{"wielded".$uctype}, $this->{"wielded".$uctype}->wield_type);
			} else {
				$this->{"wielded".$uctype} = $item;
				$this->{"wielded".$uctype}->wielded = true;
				status($this->clientid, "You wielded \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".");
			}
		} else {
			status($this->clientid, "You need to be level " . $item->level . " to wield \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"" . ".");
		}
	}

	public function unwield($item, $type)
	{
		$uctype = ucfirst($type);
		if($this->{"wielded".$uctype} != null)
		{
			$this->{"wielded".$uctype}->wielded = false;
			$this->{"wielded".$uctype} = null;
			return true;
		}
		return true;
	}

	public function useSpell($key)
	{
		$index = 0;
		if($key == "VK_U")
		{
			$index = 0;
		} else if($key == "VK_I")
		{
			$index = 1;
		} else if($key == "VK_O")
		{
			$index = 2;
		} else if($key == "VK_P")
		{
			$index = 3;
		}
		if(!$this->dead)
		{
			if(isset($this->spells[$index]))
			{
				if($this->usedSpell != -1)
				{
					if($this->usedSpell == $index && $this->radius == true)
					{
						if($this->level >= $this->spells[$index]->level)
						{
							if($this->curmana >= $this->spells[$index]->mana_use)
							{
								if($this->spells[$index]->useRadius($this)) {
									$this->curmana = $this->curmana - $this->spells[$index]->mana_use;
								}
							} else {
								status($this->clientid, "You do not have enough mana.");
							}
						} else {
							status($this->clientid, "You need to be level " . $this->spells[$index]->level . " to use " . $this->spells[$index]->name . ".");
						}
					} else {
						if($this->level >= $this->spells[$index]->level)
						{
							if($this->curmana >= $this->spells[$index]->mana_use)
							{
								if($this->spells[$index]->use($this)) {
									$this->usedSpell = $index;
									$this->curmana = $this->curmana - $this->spells[$index]->mana_use;
								} else {
									$this->usedSpell = $index;
								}
							} else {
								status($this->clientid, "You do not have enough mana.");
							}
						} else {
							status($this->clientid, "You need to be level " . $this->spells[$index]->level . " to use " . $this->spells[$index]->name . ".");
						}
					}
				} else {
					$this->usedSpell = null;
				}
			}
		} else {
			status($this->clientid, "You're dead and cannot use spells.");
		}
	}

	public function addToSpells($spell, $scroll, $faux = false, $notify = true)
	{
		$spellcount = count($this->spells);
		$item = clone $spell;
		$duped = false;
		if($spellcount < 2 OR $faux == true)
		{
			if($spellcount != 0)
			{
				foreach($this->spells as $spell)
				{
					if($item->id == $spell->id)
					{
						$duped = true;
						if($faux == false)
						{
							$spell->duplicate($this, $notify);
							return true;
							break;
						}
					}
				}
			}

			if(!$duped)
			{
				if($faux == false)
				{
					$item->created($this);
					array_push($this->spells, $item);
					return true;
				}
			}

			if($notify) {
				status($this->clientid, "You obtained \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".", "#ffff00");
			}
			if($item->rarity == "legendary")
			{
				if($notify) {
					statusBroadcast($this->name . " obtained \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"!", "#ffff00", false, $this->clientid);
				}
			}

		} else {
			$this->request('spellFull', [$item, $scroll]);
			return false;
			
		}
	}

	public function useInventory($index)
	{
		if(!$this->dead)
		{
			$index--;
			if(isset($this->inventory[$index]))
			{
				if($this->usedItem != -1)
				{
					if($this->usedItem == $index && $this->radius == true)
					{
						if($this->level >= $this->inventory[$index]->level)
						{
							if(method_exists($this->inventory[$index], 'useRadius'))
							{
								if($this->inventory[$index]->useRadius($this))
								{
									$this->inventory[$index]->curuses--;
							
									if($this->inventory[$index]->curuses == 0)
									{
										status($this->clientid, $this->inventory[$index]->name . " broke.", "#ffff00");
										unset($this->inventory[$index]);
										$this->inventory = array_values($this->inventory);
										bigBroadcast();
									}
								}
							}
						} else {
							status($this->clientid, "You need to be level " . $this->inventory[$index]->level . " to use " . $this->inventory[$index]->name . ".");
						}
					} else {
						$this->usedItem = $index;
						if($this->level >= $this->inventory[$index]->level)
						{
							if($this->inventory[$index]->use($this, $index))
							{

								$this->inventory[$index]->curuses--;
						
								if($this->inventory[$index]->curuses == 0)
								{
									status($this->clientid, $this->inventory[$index]->name . " broke.", "#ffff00");
									unset($this->inventory[$index]);
									$this->inventory = array_values($this->inventory);
									bigBroadcast();
								}
							}
						} else {
							status($this->clientid, "You need to be level " . $this->inventory[$index]->level . " to use " . $this->inventory[$index]->name . ".");
						}
					}
				} else {
					$this->usedItem = null;
				}
			}
		} else {
			status($this->clientid, "You're dead and cannot use items.");
		}
		
		phonehome($this);
	}

	public function isInInventory($item_id, $use_name = false, $use_index = false)
	{
		if(!$use_index)
		{
			foreach($this->inventory as $item)
			{
				if(!$use_name)
				{
					if($item->id == $item_id)
					{
						return true;
					}
				} elseif($use_name) {
					if($item->name == $item_id)
					{
						return true;
					}
				}
			}
		} else {
			if(isset($this->inventory[$item_id-1])) {
				return true;
			}
		}
		return false;
	}

	public function removeFromInventory($item_to_remove, $use_id = true, $reset_index = true, $use_item = false, $use_index = false)
	{
		if(!$use_item)
		{
			if(!$use_index)
			{
				if($use_id)
				{
					$i = 0;
					foreach($this->inventory as $item)
					{
							if($item->id == $item_to_remove)
							{
								if($this->inventory[$i] == $this->wieldedArmor)
								{
									$this->wieldedArmor = null;
								}
							if(isset($this->inventory[$i]->wielded))
							{
								$this->inventory[$i]->wielded = false;
							}
				if(method_exists($this->inventory[$i], 'removed'))
				{
					$this->inventory[$i]->removed($this);
				}
								unset($this->inventory[$i]);
								$this->inventory = array_values($this->inventory);
								bigBroadcast();
								return true;
							}
						$i++;
					}
				} else {
					if($this->inventory[$item_to_remove] == $this->wieldedArmor)
					{
						$this->wieldedArmor = null;
					}
							if(isset($this->inventory[$item_to_remove]->wielded))
							{
								$this->inventory[$item_to_remove]->wielded = false;
							}
					if(method_exists($this->inventory[$item_to_remove], 'removed'))
					{
						$this->inventory[$item_to_remove]->removed($this);
					}
					unset($this->inventory[$item_to_remove]);
					if($reset_index)
					{
						$this->inventory = array_values($this->inventory);
					}
					bigBroadcast();
					return true;
				}
			} else {
				if(isset($this->inventory[$item_to_remove]->wielded))
				{
					$this->inventory[$item_to_remove]->wielded = false;
				}
				if(method_exists($this->inventory[$item_to_remove], 'removed'))
				{
					$this->inventory[$item_to_remove]->removed($this);
				}
				unset($this->inventory[$item_to_remove]);
				$this->inventory = array_values($this->inventory);
				bigBroadcast();
				return true;
			}
		} else {
			$i = 0;
			foreach($this->inventory as $item)
			{
				if($item == $item_to_remove)
					{
						if($this->inventory[$i] == $this->wieldedArmor)
						{
							$this->wieldedArmor = null;
						}
						if(isset($this->inventory[$i]->wielded))
						{
							$this->inventory[$i]->wielded = false;
						}
							if(method_exists($this->inventory[$i], 'removed'))
							{
								$this->inventory[$i]->removed($this);
							}
							unset($this->inventory[$i]);
							$this->inventory = array_values($this->inventory);
							
							bigBroadcast();
							return true;
						}
				$i++;
			}
		}
	}

	public function parseInventory()
	{
		$inven = $this->inventory;
		$inv = [];
		for ($i=0; $i <10; $i++) {
			if(!isset($inven[$i]))
			{
				$inv[$i]['color'] = "rgba(255,255,255,0.7) ";
				$inv[$i]['text'] = "(empty)";
			} else {
				$inv[$i]['color'] = $inven[$i]->color;
				if(method_exists($inven[$i], "panelValue"))
				{
					$inv[$i]['text'] = $inven[$i]->name;
					$panel_string = "<span style='color:";
					$ptext = $inven[$i]->panelValue()[0];
					$pcolor = $inven[$i]->panelValue()[1];
					$inv[$i]['text'] = $inven[$i]->name . " " . $panel_string . $pcolor . " !important;'>(" . $ptext . ")</span>";
				} else {
					if(isset($inven[$i]->displayuses))
					{
						if($inven[$i]->displayuses)
						{
							$inv[$i]['text'] = $inven[$i]->name . " (" . $inven[$i]->curuses . " left)";
						} else {
							$inv[$i]['text'] = $inven[$i]->name;	
						}
					} else {
						if($inven[$i]->maxuses > 1)
						{
							$inv[$i]['text'] = $inven[$i]->name . " (" . $inven[$i]->curuses . " left)";
						} else {
							$inv[$i]['text'] = $inven[$i]->name;
						}
					}
				}
			}
			
		}
		return $inv;
	}


	public function parseSpells()
	{
		$inven = $this->spells;
		$inv = [];
		for ($i=0; $i <4; $i++) {
			if(!isset($inven[$i]))
			{
				$inv[$i]['color'] = "rgba(255,255,255,0.7) ";
				$inv[$i]['text'] = "(none)";
			} else {
				$inv[$i]['color'] = $inven[$i]->color;
				$inv[$i]['text'] = $inven[$i]->name . " <span style='color:#6495ED !important;'>(" . $inven[$i]->mana_use . ")</span> " .$inven[$i]->panelText();
			}
			
		}
		return $inv;
	}
	public function hasHook($hook)
	{
		foreach($this->inventory as $item)
		{
			if(isset($item->hook))
			{
				if(is_array($item->hook))
				{
					if(in_array($hook, $item->hook))
					{
						return true;
					}
				} else {
					if($item->hook == $hook)
					{
						return true;
					}
				}
			}
		}
		foreach($this->spells as $item)
		{
			if(isset($item->hook))
			{
				if(is_array($item->hook))
				{
					if(in_array($hook, $item->hook))
					{
						return true;
					}
				} else {
					if($item->hook == $hook)
					{
						return true;
					}
				}
			}
		}
		return false;
	}

	public function runHook()
	{
		$hook = func_get_arg(0);
		$args = func_get_args();
		array_push($args, $hook);
		$orgval = 0;
		array_splice($args, 0, 1);

		foreach($this->inventory as $item)
		{
			if(isset($item->hook))
			{
				if(is_array($item->hook))
				{
					if(in_array($hook, $item->hook))
					{
						$ranHook = call_user_func_array(array($item, 'runHook'), $args);
						 // Only return the value if the hook succeeded.
						if(!is_array($ranHook))
						{
							return $ranHook;
						} else {
							$orgval = $ranHook[1];
						}
					}
				} else {
					if($item->hook == $hook)
					{
						$ranHook = call_user_func_array(array($item, 'runHook'), $args);
						 // Only return the value if the hook succeeded.
						if(!is_array($ranHook))
						{
							if(isset($item->hook_return))
							{
								if($item->hook_return)
								{
									return $ranHook;
								} else {
									continue;
								}
							} else {
								return $ranHook;
							}
						} else {
							$orgval = $ranHook[1];
						}
					}
				}
			}
		}

		foreach($this->spells as $item)
		{
			if(isset($item->hook))
			{
				if(is_array($item->hook))
				{
					if(in_array($hook, $item->hook))
					{
						$ranHook = call_user_func_array(array($item, 'runHook'), $args);
						 // Only return the value if the hook succeeded.
						if(!is_array($ranHook))
						{
							return $ranHook;
						} else {
							$orgval = $ranHook[1];
						}
					}
				} else {
					if($item->hook == $hook)
					{
						$ranHook = call_user_func_array(array($item, 'runHook'), $args);
						 // Only return the value if the hook succeeded.
						if(!is_array($ranHook))
						{
							if(isset($item->hook_return))
							{
								if($item->hook_return)
								{
									return $ranHook;
								} else {
									continue;
								}
							} else {
								return $ranHook;
							}
						} else {
							$orgval = $ranHook[1];
						}
					}
				}
			}
		}

		return $orgval;
	}

	public function damage($amount, $type, $dealer = null)
	{
		global $safe_rooms;
		if($dealer == null) { $dealer->name = "You were"; }
		$orgamount = $amount;
		if($this->hasHook("before_damage"))
		{
			$amount = $this->runHook("before_damage", $amount, $type, $this);
		}
		$oldshield = $this->curshield;
		if($this->curshield > 0)
		{
			$this->curshield = $this->curshield - $amount;
		}
		$newshield = $this->curshield;
		if($newshield < 0)
		{
			$diff = 0 - ($newshield);
			$this->curshield = 0;
			$amount = $diff;
		} else if($oldshield == 0)
		{
			$amount = $orgamount;
		} else {
			$amount = 0;
		}
		if(!$this->invincible)
		{
			$this->curhp = $this->curhp - $amount;
		}
			if($amount < $orgamount)
			{
				$reducedamount = $orgamount - $amount;
				if(!$this->invincible)
				{
					status($this->clientid, $dealer->name . " dealt " . $orgamount . " " . $type . " damage.", "#ff5c5c");
				} else {
					status($this->clientid, $dealer->name . " tried to deal you " . $orgamount . " " . $type . " damage, but you're invincible.", "#00ff00");
				}
			} else {
				if(!$this->invincible)
				{
					status($this->clientid, $dealer->name . " dealt " . $orgamount . " " . $type . " damage.", "#ff5c5c");
				} else {
					status($this->clientid, $dealer->name . " tried to deal you " . $orgamount . " " . $type . " damage, but you're invincible.", "#00ff00");
				}
			}
			if(($this->curhp/$this->maxhp) <= ($this->auto_timeout/100))
			{
				if($this->used_auto_timeout == false)
				{
					$this->used_auto_timeout = true;
					$this->setTimeout();
				}
			}
		
		if($this->curhp <= 0)
		{
			$die = true;
			if($dealer->representation != "@") // Monster death
			{
				if($this->hasHook("before_monster_death"))
				{
					$die = $this->runHook("before_monster_death", $safe_rooms, $this);
				}
			} else {
				if($this->hasHook('before_player_death'))
				{
					$die = $this->runHook("before_player_death", $safe_rooms, $this);
				}
			}
			if($die)
			{
				$this->die();
			}
		}
	}

	public function performCharm($first = false)
	{
		if($this->charmed)
		{

			$curtime = round(microtime(true) * 1000);
			
			if(($this->charm_time+($this->charm_duration*1000)) > $curtime)
			{
				if($first)
				{
					$this->charm->charm($this);
				}
				$this->charm->charmTick($this);
				return true;
			} else {
				status($this->clientid, "Your charm has worn off.", "#ff5c5c");
				$this->charm->uncharm($this);
				$this->charmed = false;
				$this->charm = null;
				$this->charm_time = 0;
				return true;
			}
		}
	}

	public function performBurn()
	{
		if($this->burned)
		{
			$curtime = round(microtime(true) * 1000);
			if($this->last_burn == 0)
			{
				$this->first_burn = $curtime;
			}

			if(($this->first_burn+($this->burn_duration*1000)) > $curtime)
			{
				if($this->last_burn == 0 or ($curtime - $this->last_burn) >= $this->burn_frequency)
				{
					if($this->burn_player != null)
					{
						$this->damage($this->burn_damage, "fire", $this->burn_player);
					} else {
						$this->damage($this->burn_damage, "fire");
					}
					$this->last_burn = $curtime;
				}
			} else {
				if($this->is_burn_player)
				{
					status($this->burn_player->clientid, "Your burn on " . $this->name . " has worn off.", "#ff5c5c");
				}
				if($this->burn_player != null)
				{
					status($this->clientid, "Your burn from " . $this->burn_player->name . " has worn off.", "#ff5c5c");
				} else {
					status($this->clientid, "Your burn has worn off.", "#ff5c5c");
				}
				$this->burned = false;
				$this->burn_player = null;
				$this->is_burn_player = false;
			}
		}
	}

	public function performInvincible()
	{
		if($this->invincible)
		{
			$curtime = round(microtime(true)*1000);
			if($this->last_invincible == 0)
			{
				$this->first_invincible = $curtime;
			}

			if(($this->first_invincible+($this->invincible_duration*1000)) < $curtime)
			{
				status($this->clientid, "You are no longer invincible.", "#fff");
				$this->invincible = false;
				$this->last_invincible = 0;
				$this->first_invincible = 0;
				$this->invincible_duration = 0;
			} else {
				$this->last_invincible = $curtime;
			}
		}
	}


	public function invincible($duration, $thisplayer = null)
	{
		$this->invincible = true;
		$this->invincible_duration = $duration;
		$this->last_invincible = 0;
		$this->first_invincible = 0;
		status($this->clientid, "You are invincible for " . $duration ." seconds.", "#fff");
		return true;
	}

	public function charm($charm, $duration)
	{
		$this->charm_duration = $duration;
		$this->charm_time = round(microtime(true) * 1000);
		$this->charmed = true;
		$this->charm = $charm;
		$this->performCharm(true);
		return true;
		
	}


	// Frequency = how often the damage is done. 1 = 1 second.
	public function burn($damage, $duration, $frequency, $thisplayer = null, $player = true)
	{
		$this->burned = true;
		$this->burn_damage = $damage;
		$this->burn_duration = $duration;
		$this->burn_frequency = $frequency*1000;
		$this->last_burn = 0;
		$this->first_burn = 0;
		$this->is_burn_player = $player;
		if($thisplayer != null)
		{
			$this->burn_player = $thisplayer;
			status($this->clientid, "You've been burnt by " . $this->burn_player->name . ".", "#ff5c5c");
		} else {
			status($this->clientid, "You've been burnt.", "#ff5c5c");
		}
		if($this->is_burn_player)
		{
			status($this->burn_player->clientid, "You've burnt " . $this->name . ".", "#ff5c5c");	
		}
		


		$this->performBurn();
	}

	public function burnFailed($thisplayer = null)
	{
		if($thisplayer != null)
		{
			status($thisplayer->clientid, "You failed to burn " . $this->name . ".", "#ff5c5c");
		}
	}


	public function freeze($duration, $thisplayer)
	{
		if(!$this->frozen)
		{
			$this->frozen_duration = $duration;
			$this->frozen_time = time();
			$this->frozen = true;
			if(isset($thisplayer->clientid))
			{
				status($thisplayer->clientid, "You froze " . $this->name . " for " . $duration . " seconds.", "#42eef4");
			}
			status($this->clientid, "You've been frozen by " . $thisplayer->name . " for " . $duration . " seconds.", "#42eef4");
		}
	}

	public function freezeFailed($thisplayer = null)
	{
		if($thisplayer != null)
		{
			status($thisplayer->clientid, "You failed to freeze " . $this->name . ".", "#42eef4");
		}
	}

	public function unFreeze($notify = true)
	{
		$this->frozen = false;
		status($this->clientid, "You're no longer frozen.", "#42eef4");
	}

	public function isFrozen()
	{
		if($this->frozen_time == 0)
		{
			$this->frozen_time = time();
		}
		if($this->frozen && ($this->frozen_time + $this->frozen_duration) <= time())
		{
			$this->unFreeze();
			return false;
		}

		if(!$this->frozen)
		{
			return false;
		}

		return true;
	}

	public function slow($duration, $percentage, $thisplayer)
	{
		$perc = 1-($percentage / 100);
		$this->slowmovementspeed = $this->maxstamina;
		$this->maxstamina = round($this->maxstamina*$perc);
		$this->slowmaxstamina = $this->maxstamina;
		$this->curstamina = $this->maxstamina;
		$this->slowed_at = microtime(true);
		$this->slow_for = $duration;
		$this->slowed = true;
		if(isset($thisplayer->clientid))
		{
			status($thisplayer->clientid, "You slowed " . $this->name . " by " . $percentage . "% for " . $duration . " seconds.", "#42eef4");
		}
		status($this->clientid, "You've been slowed by " . $thisplayer->name . " by " . $percentage . "% for " . $duration . " seconds.", "#42eef4");
	}

	public function slowFailed($thisplayer = null)
	{
		if($thisplayer != null)
		{
			status($thisplayer->clientid, "You failed to slow " . $this->name . ".", "#42eef4");
		}
	}

	public function isSlowed()
	{
		return $this->slowed;
	}

	public function unSlow($notify = true)
	{
		$this->maxstamina = $this->slowmovementspeed;
		$this->slowmovementspeed = 0;
		$this->slowed_at = 0;
		$this->slow_for = 0;
		$this->slowed = false;
		status($this->clientid, "You're no longer slowed.", "#42eef4");
	}



	public function die()
	{
		global $players, $map;
		$this->dead = true;
		$playersalive = 0;
		foreach($players as $player)
		{
			if(!$player->dead)
			{
				$playersalive++;
			}
		}
		$map[$this->x][$this->y] = new Tile(new Floor());
		$this->x = 1000;
		$this->y = 1000;
		$this->hold = true;
		$this->force_hold = true;
		statusBroadcast($this->name . " has died a horrible death. There's " . $playersalive . " contestants left.", "#ff5c5c");
	}

	public function heal($amount, $notify = true)
	{
		$oldcur = $this->curhp;
		$this->curhp = $this->curhp + $amount;
		if($this->curhp > $this->maxhp)
		{
			$this->curhp = $this->maxhp;
		}
		$newcur = $this->curhp;
		$diff = $newcur - $oldcur;
		if($this->curhp > $this->auto_timeout)
		{
			$this->used_auto_timeout = false;
		}
		if($notify)
		{
			status($this->clientid, "You were healed " . $diff . " HP.", "#5CCC6B");
		}
	}

	public function addShield($amount, $notify = true)
	{
		$oldcur = $this->curshield;
		$this->curshield = $this->curshield + $amount;
		if($this->curshield > $this->maxshield)
		{
			$this->curshield = $this->maxshield;
		}
		$newcur = $this->curshield;
		$diff = $newcur - $oldcur;
		if($notify)
		{
			status($this->clientid, "You gained " . $diff . " shield.", "#6495ED");
		}
	}

	public function reduceMana($amount, $notify = true)
	{
		$this->curmana = $this->curmana - $amount;
		if($notify)
		{
			status($this->clientid, "You used " . $amount . " mana.", "#ff5c5c");
		}
	}
	public function addMana($amount, $notify = true)
	{
		$oldcur = $this->curmana;
		$this->curmana = $this->curmana + $amount;
		if($this->curmana > $this->maxmana)
		{
			$this->curmana = $this->maxmana;
		}
		$newcur = $this->curmana;
		$diff = $newcur - $oldcur;
		if($notify)
		{
			status($this->clientid, "You gained " . $amount . " mana.", "#6495ED");
		}
	}

	public function request($requestname, $arg = null)
	{
		$this->hold = true;
		$this->requestVar = $requestname;
		if($arg != null)
		{
			$this->requestArg = $arg;
			$this->{$requestname . "Request"}($arg);	
		} else {
			$this->{$requestname . "Request"}();
		}
		return true;
	}

	public function unsetRequest()
	{
		$this->hold = false;
		$this->unsetTiles();
		$this->requestVar = null;
		$this->requestArg = null;
		bigBroadcast();
	}

	public function unsetTiles()
	{
		global $map;
		foreach($this->radiustiles as $x => $yar)
		{
			foreach ($yar as $y => $ytile)
			{
				if($map[$x][$y]->representation() != "@")
				{
					$map[$x][$y]->resetColor($this->clientid);
				}
			}
		}
	}

	public function getInventoryIndex($item)
	{
		foreach ($this->inventory as $index => $value) {
			if($item == $value)
			{
				return $index;
			}
		}
		return -1;
	}

	public function itemUseRequest($item)
	{
		return $item->useRequest($this);
	}

	public function itemUseResponse($message)
	{
		return $this->requestArg->useResponse($message, $this);
	}


	public function spellFullRequest($spell)
	{
		status($this->clientid, "Your spellbook is full. In which spot do you want to put \"<span style='color:".$spell[0]->color." !important;'>" . $spell[0]->name . "</span>\"? <span style='color:#ff0000;'>The old spell will disappear!</span> Type either \"E\" or \"Q\". Type \"0\" to cancel.", "#ffff00", true);
		return true;		
	}

	public function spellFullResponse($message)
	{
		$message = ucfirst($message);
		if($message == "E")
		{
			unset($this->spells[1]);
			$this->spells = array_values($this->spells); 
			$this->requestArg[0]->created($this);
			array_push($this->spells, $this->requestArg[0]);
			$i = 0;
			foreach($this->inventory as $item)
			{
				if($item === $this->requestArg[1])
				{
					$this->removeFromInventory($i, false);
				}
				$i++;
			}
		}
		if($message == "Q")
		{
			unset($this->spells[0]);
			$this->spells = array_values($this->spells); 
			$this->requestArg[0]->created($this);
			array_unshift($this->spells, $this->requestArg[0]);
			$i = 0;
			foreach($this->inventory as $item)
			{
				if($item === $this->requestArg[1])
				{
					$this->removeFromInventory($i, false);
				}
				$i++;
			}
			return true;
		}
		if(is_numeric($message) && $message == 0)
		{
			return false;
		}
	}

	public function inventoryFullRequest($item)
	{
		status($this->clientid, "Your inventory is full. In which spot do you want to put \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"? Type \"0\" to put it nowhere.", "#ffff00", true);
		return true;
	}

	public function inventoryFullResponse($message)
	{
		global $map;
		if(is_numeric($message))
		{
			$message = (int)$message;
		} else {
			return false;
		}
		if(is_numeric($message) && $message > -1 && $message < 10 && $message != 0)
		{
			//$this->removeFromInventory($message-1,false);
			$this->inventory[$message-1] = $this->requestArg;
			$this->addToInventory($this->requestArg, true);
			return true;
		} else if (is_numeric($message) && $message == 0) {
			$item = $this->requestArg;
			status($this->clientid, "You did not pickup \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".", "#ffff00");
			if($map[$this->x+1][$this->y]->representation() == ".")
			{
				setTile($this->x+1, $this->y, new Tile(new Itemtile($item)));
			} elseif($map[$this->x-1][$this->y]->representation() == ".") {
				setTile($this->x-1, $this->y, new Tile(new Itemtile($item)));
			} elseif($map[$this->x][$this->y+1]->representation() == ".") {
				setTile($this->x, $this->y+1, new Tile(new Itemtile($item)));
			} elseif($map[$this->x][$this->y-1]->representation() == ".") {
				setTile($this->x, $this->y-1, new Tile(new Itemtile($item)));
			} else {
				status($this->clientid, "There is nowhere to drop your item, it has vanished into the void.", "#ffff00");
			}	
			return true;
		} else {
			if($this->requestArg != null)
			{
				$this->request($this->requestVar, $this->requestArg);
			} else {
				$this->request($this->requestVar);
			}
			return false;
		}
	}

	public function swapRequest()
	{
		status($this->clientid, "What would you like to swap?", "#ffff00", true);
		return true;
	}

	public function swapResponse($message)
	{
		$item1 = substr($message, 0, 1);
		$item2 = substr($message, 1, 1);
		if(is_numeric($item1) && is_numeric($item2) && $item1 > -1 && $item1 < 10 && $item1 != 0  && $item2 > -1 && $item2 < 10 && $item2 != 0)
		{
			if($this->isInInventory($item1, false, true) && $this->isInInventory($item2, false, true))
			{
				$itemm1 = $this->inventory[$item1-1];
				$itemm2 = $this->inventory[$item2-1];
				$this->inventory[$item1-1] = $itemm2;
				$this->inventory[$item2-1] = $itemm1;
				status($this->clientid, "You swapped \"<span style='color:".$itemm1->color." !important;'>" . $itemm1->name . "</span>\" with \"<span style='color:".$itemm2->color." !important;'>" . $itemm2->name . "</span>\".", "#ffff00");
				bigBroadcast();
			} else {
				status($this->clientid, "It was not possible to swap these items", "#ffff00");
			}

		} else if(strtolower($item1) == "u" or strtolower($item1) == "i" or strtolower($item1) == "o" or strtolower($item1) == "p" or strtolower($item2) == "u" or strtolower($item2) == "i" or strtolower($item2) == "o" or strtolower($item2) == "p" and !is_numeric($item1) and !is_numeric($item2)) {
			$item1index = -1;
			if(strtolower($item1) == "u")
			{
				$item1index = 0;
			} else if(strtolower($item1) == "i")
			{
				$item1index = 1;
			} else if(strtolower($item1) == "o")
			{
				$item1index = 2;
			} else if(strtolower($item1) == "p")
			{
				$item1index = 3;
			}
			$item2index = -1;
			if(strtolower($item2) == "u")
			{
				$item2index = 0;
			} else if(strtolower($item2) == "i")
			{
				$item2index = 1;
			} else if(strtolower($item2) == "o")
			{
				$item2index = 2;
			} else if(strtolower($item2) == "p")
			{
				$item2index = 3;
			}
			if($item1index != -1 && $item2index != -1)
			{
				if(isset($this->spells[$item1index]) && isset($this->spells[$item2index]))
				{
					$itemm1 = $this->spells[$item1index];
					$itemm2 = $this->spells[$item2index];
					$this->spells[$item1index] = $itemm2;
					$this->spells[$item2index] = $itemm1;
					status($this->clientid, "You swapped \"<span style='color:".$itemm1->color." !important;'>" . $itemm1->name . "</span>\" with \"<span style='color:".$itemm2->color." !important;'>" . $itemm2->name . "</span>\".", "#ffff00");
					bigBroadcast();
				} else {
					status($this->clientid, "It was not possible to swap these spells.", "#ffff00");
				}
			} else {
					status($this->clientid, "It was not possible to swap these spells.", "#ffff00");
			}
		} else {
			status($this->clientid, "You did not swap.", "#ffff00");
			return false;
		}
	}


	public function characterRequest()
	{
		return true;
	}

	public function characterResponse($data)
	{
		global $ready, $massive, $encryption_key;
		
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		$character = json_decode(openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv), true);

		$this->name = $character['name'];
		$this->level = $character['level'];
		$this->maxxp = $character['maxxp'];
		$this->curxp = $character['curxp'];
		$this->maxhp = $character['hp'];
		$this->curhp = $this->maxhp;
		$this->maxmana = $character['mana'];
		$this->curmana = $this->maxmana;
		$this->coins = $character['gold'];
		$this->userid = $character['user_id'];
		$this->characterid = $character['id'];
		foreach($character['inventory'] as $inv_item)
		{
			$this->addToInventory(new $inv_item['item']['initializer'], false, false, false);
				
		}
		return true;
	}

	public function nameRequest()
	{
		$this->state = "nameRequest";
		status($this->clientid, "Please enter your name.", "#ffffff", true);
		return true;
	}

	public function nameResponse($name)
	{
		global $ready, $keybindings;
		$this->name = preg_replace('/\s+/', '', $name);
		$ready = true;
		setLobby($this->clientid);
		status($this->clientid, "Your name has been set. Press \"".$this->getKeybinding("SHOW_SETTINGS")."\" to open settings, if you want to change your name.");
		return true;
	}

	public function dropRequest()
	{
		global $keybindings;
		status($this->clientid, "Which item(s) would you like to drop? Press ".$this->getKeybinding("ESCAPE")." to cancel.", "#ffff00", true);
		return true;
	}

	public function dropResponse($string)
	{
		global $map;
		$ar = str_split($string);
		rsort($ar);
		foreach($ar as $string)
		{
			if(is_numeric($string) && $string > 0 && $string < 10)
			{
				if(isset($this->inventory[$string-1]))
				{

					status($this->clientid, "You have dropped \"<span style='color:".$this->inventory[$string-1]->color." !important;'>" . $this->inventory[$string-1]->name . "</span>\".", "#ffff00");
					
					// Drops always occur to the right of the player first, with the current code. Change this to be random.

					if($map[$this->x+1][$this->y]->representation() == ".")
					{
						setTile($this->x+1, $this->y, new Tile(new Itemtile($this->inventory[$string-1])));
						$this->removeFromInventory($string-1, false);
					} elseif($map[$this->x-1][$this->y]->representation() == ".") {
						setTile($this->x-1, $this->y, new Tile(new Itemtile($this->inventory[$string-1])));
						$this->removeFromInventory($string-1, false);
					} elseif($map[$this->x][$this->y+1]->representation() == ".") {
						setTile($this->x, $this->y+1, new Tile(new Itemtile($this->inventory[$string-1])));
						$this->removeFromInventory($string-1, false);
					} elseif($map[$this->x][$this->y-1]->representation() == ".") {
						setTile($this->x, $this->y-1, new Tile(new Itemtile($this->inventory[$string-1])));
						$this->removeFromInventory($string-1, false);
					} else {
						status($this->clientid, "There is nowhere to drop your item.", "#ffff00");
					}
					//return true;
				} else {
					status($this->clientid, "You do not have an item at slot " . ($string) . " in your inventory.", "#ffff00");
					//return true;
				}		
			}
		}
		return true;		
	}

	public function performAction()
	{
		/* Add shop functionality to non-mobs here. */
		if($this->action_target != null)
		{
			$this->selected_setting = 0;
			$this->action_target->action($this);
		}

	}

	public function getCharacterMenu()
	{
		if($this->in_shop)
		{
			if(method_exists($this->action_target, 'getMenu'))
			{
				return $this->action_target->getMenu($this);
			}
		}
	}

	public function performMenuAction()
	{
		if($this->in_shop)
		{
			if(method_exists($this->action_target, 'performMenuAction'))
			{
				return $this->action_target->performMenuAction($this);
			}
		}
	}

	public function displaySettings()
	{
		$this->show_settings = true;
	}

	public function changeSetting()
	{
		switch ($this->selected_setting) {
			case 0:
				if($this->state == "lobby")
				{
					status($this->clientid, "Please enter your new name.", "#ffff00", true);
					$this->request('setting');

				} else {
					status($this->clientid, "You can only set your name in the lobby.");
				}
				break;
			case 1:
				status($this->clientid, "Please enter the percentage of HP at which you would like to auto suspend. Type 0 to disable auto suspend.", "#ffff00", true);
				$this->request('setting');
				break;
			default:
				$i = ($this->selected_setting-2);
				//array_values($this->keybindings)[$i]
				status($this->clientid, "Enter new keybinding for " . array_keys($this->keybindings)[$i] . ". Has to be a VK keycode without VK_ prepended.");
				$this->request('setting');
				break;
		}
	}

	public function settingRequest()
	{
		return true;
	}

	public function settingResponse($string)
	{
		global $default_auto_timeout, $Server;
			switch ($this->selected_setting) {
				case 0:
					if($this->state == "lobby")
					{
						$this->name = preg_replace('/\s+/', '', $string);
						status($this->clientid, "Your name has been set.");
					} else {
						status($this->clientid, "You can only set your name in the lobby.");
					}
					break;
				case 1:
					if(is_numeric($string))
					{
						if($default_auto_timeout != -1)
						{
							$this->auto_timeout = $string;
							$this->used_auto_timeout = false;
							status($this->clientid, "You will now automatically use a suspension, if you have one, when you hit " . $this->auto_timeout . "% of your max HP.");
						} else {
							status($this->clientid, "Auto suspend is disabled on this server.");
						}
					} else {
						status($this->clientid, "Please enter a valid number.");
					}
					break;
				default:
					$key = str_replace("VK_", "", trim($string));
					$i = ($this->selected_setting-2);
					$this->keybindings[array_keys($this->keybindings)[$i]] = "VK_" . strtoupper($string);
					status($this->clientid, "The new keybinding for " . array_keys($this->keybindings)[$i] . " is now "  . array_values($this->keybindings)[$i] . ".");
					sendKeybindings($this->clientid);
					break;
			}

		return true;
	}

	public function getSettings()
	{
		global $keybindings;
		$strings = [];
		$options = [];
		$localoptions = [];
		array_push($localoptions, ["text" => "Name: " . $this->name]);
		array_push($localoptions, ["text" => "Auto suspend at " . $this->auto_timeout . "% of max HP."]);
		$i = 1;
		foreach($this->keybindings as $key => $binding)
		{
			array_push($localoptions, ["text" => "Key for " . $key . ": " . str_replace("VK_", "", $binding)]);
			$i++;
		}
		$this->max_settings = $i;
		if($this->describe_function)
		{
			$funcdesc = "true";
		} else {
			$funcdesc = "false";
		}
		//array_push($options, ["text" => "Show function next to name: " . $funcdesc]);

		//$i = 0;
		/*foreach ($options as $key => $value) {
			if($this->selected_setting == $key)
			{
				$options[$i]["text"] = "[X] " . $options[$i]["text"];
			} else {
				$options[$i]["text"] = "[ ] " . $options[$i]["text"];
			}
			$i++;
		}*/

		if($this->selected_setting > 4)
		{
			$start = $this->selected_setting-4;
			for($i = $start; $i < ($start+5); $i++)
			{
				if($this->selected_setting == ($i))
				{
					$options[$i]["text"] = "[X] " . $localoptions[$i]["text"];
				} else {
					$options[$i]["text"] = "[ ] " . $localoptions[$i]["text"];
				}
			}
		} else {
			for($i = 0; $i < 5; $i++)
			{
				if($this->selected_setting == ($i))
				{
					$options[$i]["text"] = "[X] " . $localoptions[$i]["text"];
				} else {
					$options[$i]["text"] = "[ ] " . $localoptions[$i]["text"];
				}
			}
		}


		/*for($i = (ceil(($this->selected_setting+1)/5)); $i < (ceil(($this->selected_setting+1)/5)) + 5; $i++)
		{
			if(($i-1) <= $this->max_settings)
			{
					if($this->selected_setting == ($i-1))
					{
						$options[$i]["text"] = "[X] " . $localoptions[$i]["text"];
					} else {
						$options[$i]["text"] = "[ ] " . $localoptions[$i]["text"];
					}
				}
		}*/
		array_push($strings, ["text" => "Your settings: (".($this->selected_setting+1)." of ".($this->max_settings+1).")"]);
		array_push($strings, ["text" => " "]);
		$lines = array_merge($strings, $options);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Use the arrows to move up and down"]);
		array_push($lines, ["text" => "and press \"".str_replace("VK_", "", $keybindings['SPACE'])."\" to change value."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['ESCAPE'])."\" to leave menu."]);

		return $lines;
	}

	public function describeRequest()
	{
		global $keybindings;
		status($this->clientid, "What would you like to have described? Press ".str_replace("VK_", "", $keybindings['ESCAPE'])." to cancel.", "#ffff00", true);
		return true;
	}

	public function describeResponse($string)
	{
		$ar = str_split($string);
		foreach($ar as $string)
		{
			if(is_numeric($string) && $string > 0 && $string < 10)
			{
				if(!$this->in_shop)
				{
					if(isset($this->inventory[$string-1]))
					{
						if(method_exists($this->inventory[$string-1], "describe")) {
							$this->inventory[$string-1]->describe($this->clientid);
						} else {
							if(isset($this->inventory[$string-1]->type))
							{
								$curitem = $this->inventory[$string-1];
								switch ($curitem->type) {
									case 'melee':
										status($this->clientid, "<span style='color:".$curitem->color." !important;'>" . $curitem->name . "</span>: Damage: ".$curitem->damage . ". Atk. spd.: " .$curitem->dps() . " dps. Level: " .$curitem->level . ". Rarity: " . ucfirst($this->inventory[$string-1]->rarity) . ". " . $curitem->description, "#ffff00");
										break;
									default:
										# code...
										break;
								}
							} else {
								status($this->clientid, "<span style='color:".$this->inventory[$string-1]->color." !important;'>" . $this->inventory[$string-1]->name . "</span>: " .$this->inventory[$string-1]->description . " Rarity: " . ucfirst($this->inventory[$string-1]->rarity) . ".", "#ffff00");
							}
						}
						//return true;
					} else {
						status($this->clientid, "You do not have an item at slot " . ($string) . " in your inventory.", "#ffff00");
						//return true;
					}	
				} else {
					if(isset($this->action_target->stock[$string-1]))
					{
						if(method_exists($this->action_target->stock[$string-1], "describe")) {
							$this->action_target->stock[$string-1]->describe($this->clientid);
						} else {
							status($this->clientid, "<span style='color:".$this->action_target->stock[$string-1]->color." !important;'>" . $this->action_target->stock[$string-1]->name . "</span>: " .$this->action_target->stock[$string-1]->description . " Rarity: " . ucfirst($this->action_target->stock[$string-1]->rarity) . ". Level: " . $this->action_target->stock[$string-1]->level . ".", "#ffff00");
						}
						//return true;
					} else {
						status($this->clientid, "This shop does not have an item at slot " . ($string) . ".", "#ffff00");
						//return true;
					}	
				}
			} else if(strtolower($string) == "q" or strtolower($string) == "e")
			{
				$orgstring = strtoupper($string);
				if(strtolower($string) == "q")
				{
					$string = 0;
				} else if(strtolower($string) == "e")
				{
					$string = 1;
				}
				if(isset($this->spells[$string]))
				{
					if(method_exists($this->spells[$string], "describe")) {
						$this->spells[$string]->describe($this->clientid);
					} else {
						status($this->clientid, "<span style='color:".$this->spells[$string]->color." !important;'>" . $this->spells[$string]->name . "</span>: " .$this->spells[$string]->description . " Rarity: " . ucfirst($this->spells[$string]->rarity) . ". Level: " . $this->spells[$string]->level . ".", "#ffff00");
					}
					//return true;
				} else {
					status($this->clientid, "You do not have an spell at slot " . ($orgstring) . " in your spells.", "#ffff00");
					//return true;
				}	
			}
		}
		return true;
	}
}

?>
