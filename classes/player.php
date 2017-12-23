<?php

class Player
{
	public $clientid;
	public $name;
	public $level;
	public $curhp;
	public $maxhp;
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
	public $describe_function;
	public $on_tile;
	public $coins;
	public $waypoint_x;
	public $waypoint_y;
	public $in_shop;
	public $action_text;

	public function __construct($Clientid)
	{
		global $default_auto_timeout;
		$this->clientid = $Clientid;
		$this->name = "null";
		$this->level = 1;
		$this->curhp = 20;
		$this->maxhp = 20;
		$this->curmana = 20;
		$this->maxmana = 20;
		$this->curxp = 0;
		$this->maxxp = 14;
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
		$this->describe_function = false;
		$this->on_tile = null;
		$this->coins = 0;
		$this->waypoint_x = -1;
		$this->waypoint_y = -1;
		$this->in_shop = false;
		$this->action_text = "No action";
	}

	public function move($x_veloc = 0, $y_veloc = 0)
	{
		if(!$this->hold && !$this->radius && !$this->force_hold)
		{
			if(movePlayerTile($this->x, $this->y, ($this->x + $x_veloc), ($this->y + $y_veloc), $this)){
				$this->x = $this->x + $x_veloc;
				$this->y = $this->y + $y_veloc;
				$check_for_action = $this->checkForAction();
				if($check_for_action['relevant'] == true)
				{
					$this->action_text = ($check_for_action['object']->action_text);
				} else {
					$this->action_text = "No action.";
				}
			}
		}
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
		if($this->hasHook("after_kill"))
		{
			$this->runHook("after_kill", $enemy, $this);
		}
		$random = rand(0,100);
		if($random > 50)
		{
			$this->coins += floor(($enemy->damage + ($enemy->basehp/1.3) + (pow($enemy->level,1.3)))/2.7);
		}
		$exp = $enemy->damage + ($enemy->basehp/1.3) + (pow($enemy->level,1.3));
		$this->gainExp($exp);
	}

	public function gainExp($exp)
	{
		$this->curxp = $this->curxp + floor($exp);
		if($this->curxp >= $this->maxxp)
		{
			$this->levelUp();
		}
	}
	public function levelUp()
	{
		global $players, $mobs;
		$this->level++;
		$this->curtimeout = $this->maxtimeout;
		// Calc new maxhp.
		$additionalhp = round(pow(($this->level-1),1.15));
		$this->maxhp = $this->maxhp + $additionalhp;
		if($this->curhp < round($this->maxhp/2))
		{
			$this->curhp = round($this->maxhp/2);
		}
		$additionalmana = round(pow(($this->level-1),1.10));
		$this->maxmana = $this->maxmana + $additionalmana;
		$this->curmana = $this->maxmana;
		if($this->curhp > $this->auto_timeout)
		{
			$this->used_auto_timeout = false;
		}
		$highestlvl = $this->level;
		foreach($players as $curplayer)
		{
			if($curplayer->level > $highestlvl)
			{
				$highestlvl = $curplayer->level;
			}
		}

		if($highestlvl == $this->level)
		{
			$i = 0;
			foreach($mobs as $curmob)
			{
				if($curmob->target == null && $curmob->level < $this->level) // Not in combat
				{
					$curmob->levelUp();
					$i++;
				}
			}
		}
		status($this->clientid, "You've gained a level!", "#ff33cc");
		statusBroadcast($this->name . " reached level " . $this->level . "!", "#ff33cc", false, $this->clientid);
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

	public function addHealthpot($amount = 1)
	{
		$this->healthpots = $this->healthpots + $amount;
		if($amount != 1)
		{
			status($this->clientid, "You picked up ".$amount." \"<span style='color:#5CCC6B !important;'>Health Potions</span>\".", "#ffff00");
		} else {
			status($this->clientid, "You picked up a \"<span style='color:#5CCC6B !important;'>Health Potion</span>\".", "#ffff00");
		}
		return true;
	}

	public function useHealthpot()
	{
		if($this->healthpots > 0 && $this->curhp != $this->maxhp)
		{
			$this->heal(5);
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

	public function addManapot($amount = 1)
	{
		$this->manapots = $this->manapots + $amount;
		if($amount != 1)
		{
			status($this->clientid, "You picked up ".$amount." \"<span style='color:#6495ED !important;'>Mana Potions</span>\".", "#ffff00");
		} else {
			status($this->clientid, "You picked up a \"<span style='color:#6495ED !important;'>Mana Potion</span>\".", "#ffff00");
		}
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
		if($this->waypoint_x < 0)
		{
			$waypoint_x = 0;
			$waypoint_y = 0;
		} else {
			$waypoint_x = ($this->x - $this->waypoint_x);
			$waypoint_y = ($this->waypoint_y - $this->y);
		}
		return ["name" => $this->name, "curhp" => $this->curhp, "maxhp" => $this->maxhp, "curmana" => $this->curmana, "maxmana" => $this->maxmana, "curxp" => $this->curxp, "maxxp" => $this->maxxp, "level" => $this->level, "inventory" => $this->parseInventory(), "spells" => $this->parseSpells(), "x" => $this->x, "y" => $this->y, "armor" => $this->parseArmor(), "healthpots" => $this->healthpots, "manapots" => $this->manapots, "curtimeout" => $this->curtimeout, "maxtimeout" => $this->maxtimeout, "coins" => "<span style='color: #ffd700 !important;'>" . $this->coins . "</span>", "waypoint_x" => $waypoint_x, "waypoint_y" => $waypoint_y, "action_text" => $this->action_text];
	}

	public function setWaypoint()
	{
		$this->waypoint_x = $this->x;
		$this->waypoint_y = $this->y;
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

	public function addToInventory($item, $faux = false, $notify = true)
	{
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
				status($this->clientid, "You picked up \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".", "#ffff00");
			}
			if($item->rarity == "legendary")
			{
				if($notify) {
					statusBroadcast($this->name . " picked up \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"!", "#ffff00", false, $this->clientid);
				}
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

	public function addToSpells($spell, $faux = false, $notify = true)
	{
		$spellcount = count($this->spells);
		$item = clone $spell;
		$duped = false;
		if($spellcount < 4 OR $faux == true)
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
							break;
						}
					}
				}
			}

			if(!$duped)
			{
				if($faux == false)
				{
					array_push($this->spells, $item);
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
			$this->request('inventoryFull', $item);
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
						} else {
							status($this->clientid, "You need to be level " . $this->inventory[$index]->level . " to use " . $this->inventory[$index]->name . ".");
						}
					} else {
						$this->usedItem = $index;
						if($this->level >= $this->inventory[$index]->level)
						{
							if($this->inventory[$index]->use($this))
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

	public function removeFromInventory($item_to_remove, $use_id = true, $reset_index = true, $use_item = false)
	{
		if(!$use_item)
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
				unset($this->inventory[$item_to_remove]);
				if($reset_index)
				{
					$this->inventory = array_values($this->inventory);
				}
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
				if(method_exists($inven[$i], panelValue))
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
							return $ranHook;
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
		if($dealer == null) { $dealer->name = "You were"; }
		$orgamount = $amount;
		if($this->hasHook("before_damage"))
		{
			$amount = $this->runHook("before_damage", $amount, $type, $this);
		}
		$this->curhp = $this->curhp - $amount;
		if($amount < $orgamount)
		{
			$reducedamount = $orgamount - $amount;
			status($this->clientid, $dealer->name . " dealt " . $amount . " " . $type . " damage. " . $reducedamount . " damage was reduced.", "#ff5c5c");
		} else {
			status($this->clientid, $dealer->name . " dealt " . $amount . " " . $type . " damage.", "#ff5c5c");
		}
		if($this->curhp <= $this->auto_timeout)
		{
			if($this->used_auto_timeout == false)
			{
				$this->used_auto_timeout = true;
				$this->setTimeout();
			}
		}
		if($this->curhp <= 0)
		{
			$this->die();
		}
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
		$this->curmana = $this->curhp + $amount;
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

	public function inventoryFullRequest($item)
	{
		status($this->clientid, "Your inventory is full. In which spot do you want to put \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\"? Type \"0\" to put it nowhere.", "#ffff00", true);
		return true;
	}

	public function inventoryFullResponse($message)
	{
		if(is_numeric($message) && $message > -1 && $message < 10 && $message != 0)
		{
			//$this->removeFromInventory($message-1,false);
			$this->inventory[$message-1] = $this->requestArg;
			$this->addToInventory($this->requestArg, true);
			return true;
		} else if (is_numeric($message) && $message == 0) {
			$item = $this->requestArg;
			status($this->clientid, "You did not pickup \"<span style='color:".$item->color." !important;'>" . $item->name . "</span>\".", "#ffff00");
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

	public function nameRequest()
	{
		$this->state = "nameRequest";
		status($this->clientid, "Please enter your name.", "#ffffff", true);
		return true;
	}

	public function nameResponse($name)
	{
		global $ready;
		$this->name = preg_replace('/\s+/', '', $name);
		$ready = true;
		setLobby($this->clientid);
		status($this->clientid, "Your name has been set. Press \"H\" to open settings, if you want to change your name.");
		$this->cheats = true;
		$this->hardcheats = true;
		return true;
	}

	public function dropRequest()
	{
		status($this->clientid, "Which item(s) would you like to drop? Press esc to cancel.", "#ffff00", true);
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
				status($this->clientid, "Please enter the HP at which you would like to auto suspend. Type 0 to disable auto suspend.", "#ffff00", true);
				$this->request('setting');
				break;
			case 2:
				status($this->clientid, "Please enter 1 to enable, and 0 to disable", "#ffff00", true);
				$this->request('setting');
				break;
			default:
				status($this->clientid, "Setting 2.");
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
		global $default_auto_timeout;
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
							status($this->clientid, "You will now automatically use a suspension, if you have one, when you hit " . $this->auto_timeout . " HP.");
						} else {
							status($this->clientid, "Auto suspend is disabled on this server.");
						}
					} else {
						status($this->clientid, "Please enter a valid number.");
					}
					break;
				case 2:
					if(is_numeric($string))
					{
						if($string == 1)
						{
							$this->describe_function = true;
							status($this->clientid, "Functional describes enabled");
						} else {
							$this->describe_function = false;
							status($this->clientid, "Functional describes disabled");
						}
					}
					break;
				default:
					status($this->clientid, "Setting 2.");
					break;
			}

		return true;
	}

	public function getSettings()
	{
		$strings = [];
		$options = [];
		array_push($options, ["text" => "Name: " . $this->name]);
		array_push($options, ["text" => "Auto suspend at " . $this->auto_timeout . " HP."]);
		if($this->describe_function)
		{
			$funcdesc = "true";
		} else {
			$funcdesc = "false";
		}
		//array_push($options, ["text" => "Show function next to name: " . $funcdesc]);

		$i = 0;
		foreach ($options as $key => $value) {
			if($this->selected_setting == $key)
			{
				$options[$i]["text"] = "[X] " . $options[$i]["text"];
			} else {
				$options[$i]["text"] = "[ ] " . $options[$i]["text"];
			}
			$i++;
		}

		array_push($strings, ["text" => "Your settings:"]);
		array_push($strings, ["text" => " "]);
		$lines = array_merge($strings, $options);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Use the arrows to move up and down"]);
		array_push($lines, ["text" => "and press \"space\" to change value."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"escape\" to leave menu."]);

		return $lines;
	}

	public function describeRequest()
	{
		status($this->clientid, "What would you like to have described? Press esc to cancel.", "#ffff00", true);
		return true;
	}

	public function describeResponse($string)
	{
		$ar = str_split($string);
		foreach($ar as $string)
		{
			if(is_numeric($string) && $string > 0 && $string < 10)
			{
				if(isset($this->inventory[$string-1]))
				{
					if(method_exists($this->inventory[$string-1], "describe")) {
						$this->inventory[$string-1]->describe($this->clientid);
					} else {
						status($this->clientid, "<span style='color:".$this->inventory[$string-1]->color." !important;'>" . $this->inventory[$string-1]->name . "</span>: " .$this->inventory[$string-1]->description . " Rarity: " . ucfirst($this->inventory[$string-1]->rarity) . ". Level: " . $this->inventory[$string-1]->level . ".", "#ffff00");
					}
					//return true;
				} else {
					status($this->clientid, "You do not have an item at slot " . ($string) . " in your inventory.", "#ffff00");
					//return true;
				}		
			} else if(strtolower($string) == "u" or strtolower($string) == "i" or strtolower($string) == "o" or strtolower($string) == "p")
			{
				$orgstring = strtoupper($string);
				if(strtolower($string) == "u")
				{
					$string = 0;
				} else if(strtolower($string) == "i")
				{
					$string = 1;
				} else if(strtolower($string) == "o")
				{
					$string = 2;
				} else if(strtolower($string) == "p")
				{
					$string = 3;
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