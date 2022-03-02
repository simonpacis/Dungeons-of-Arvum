<?php
include('mapfunctions.php');
include('keybindings.php');


function keypress($clientID, $key)
{
	global $players, $keybindings;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}

	if(!$players[$clientID]->dead)
	{
	checkMobs();
	$players[$clientID]->regenerate();
	if($key == $players[$clientID]->keybindings['UP'] or $key == $players[$clientID]->keybindings['DOWN'] OR $key == $players[$clientID]->keybindings['LEFT'] OR $key == $players[$clientID]->keybindings['RIGHT'] OR $key == $players[$clientID]->keybindings['UP_1'] OR $key == $players[$clientID]->keybindings['DOWN_1'] OR $key == $players[$clientID]->keybindings['RIGHT_1'] OR $key == $players[$clientID]->keybindings['LEFT_1'])
	{
		if(!$players[$clientID]->show_settings && !$players[$clientID]->in_shop)
		{
			$players[$clientID]->escape();
			movePlayer($clientID, $key);
		} else {
			if(($key == $players[$clientID]->keybindings['DOWN'] OR $key == $players[$clientID]->keybindings['DOWN_1']))
			{
				if($players[$clientID]->selected_setting < $players[$clientID]->max_settings)
				{
					$players[$clientID]->selected_setting++;

				}
			} else if(($key == $players[$clientID]->keybindings['UP'] OR $key == $players[$clientID]->keybindings['UP_1']))
			{
				if($players[$clientID]->selected_setting > 0)
				{
					$players[$clientID]->selected_setting--;	
				}
			} else if($key == $players[$clientID]->keybindings['LEFT'])
			{
				if($players[$clientID]->selected_setting > 5)
				{
					$players[$clientID]->selected_setting = 5;
				} else {
					if($players[$clientID]->selected_setting > 0)
					{
						$players[$clientID]->selected_setting--;
					}
				}
			} else if($key == $players[$clientID]->keybindings['RIGHT'])
			{
				if(ceil($players[$clientID]->selected_setting/5) < ceil($players[$clientID]->max_settings/5))
				{
					$players[$clientID]->selected_setting = (((ceil($players[$clientID]->selected_setting/5)*5)));
				}
			}
		}
	}
	if($players[$clientID]->show_settings == false || $players[$clientID]->in_shop == false)
	{



		if($key == $players[$clientID]->keybindings['INVENTORY_1'] or $key == $players[$clientID]->keybindings['INVENTORY_2'] or $key == $players[$clientID]->keybindings['INVENTORY_3'] or $key == $players[$clientID]->keybindings['INVENTORY_4'] or $key == $players[$clientID]->keybindings['INVENTORY_5'] or $key == $players[$clientID]->keybindings['INVENTORY_6'] or $key == $players[$clientID]->keybindings['INVENTORY_7'] or $key == $players[$clientID]->keybindings['INVENTORY_8'] or $key == $players[$clientID]->keybindings['INVENTORY_9'])
		{
			if(!$players[$clientID]->inTimeout())
			{
				$inventory_index = substr(array_search($key, $keybindings), -1);
				$players[$clientID]->useInventory($inventory_index);
			} else {
				status($clientID, "You're unable to use items when you're suspended.");
			}
		}

		if($key == "VK_U" or $key == "VK_I" or $key == "VK_O" or $key == "VK_P")
		{
			switch ($key) {
				case 'VK_U':
					keypress($clientID, "VK_1");
					
					break;
				case 'VK_I':
					keypress($clientID, "VK_2");
					
					break;				
				case 'VK_O':
					keypress($clientID, "VK_3");
					
					break;
				case 'VK_P':
					keypress($clientID, "VK_4");
					
					break;
				default:
					
					break;
			}
			
		}

		if($key == $players[$clientID]->keybindings["SPELL_1"] or $key == $players[$clientID]->keybindings["SPELL_2"])
		{
			if($key == $players[$clientID]->keybindings["SPELL_1"])
			{
				$key = "VK_U";
			}

			if($key == $players[$clientID]->keybindings["SPELL_2"])
			{
				$key = "VK_I";
			}
			if(!$players[$clientID]->inTimeout())
			{
				$players[$clientID]->useSpell($key);
			} else {
				status($clientID, "You're unable to use spells when you're suspended");
			}
		}

		if($key == $players[$clientID]->keybindings["SUSPEND"])
		{
			if(!$players[$clientID]->inTimeout())
			{
				$players[$clientID]->setTimeout();
			} else {
				$players[$clientID]->unsetTimeout();
			}
		}


		if($key == $players[$clientID]->keybindings["SWAP"])
		{
			$players[$clientID]->request('swap');
		}


		if($key == $players[$clientID]->keybindings["DESCRIBE"])
		{
			if(!$players[$clientID]->in_shop)
			{
				$players[$clientID]->request('describe');
			} else {
				$players[$clientID]->describeResponse($players[$clientID]->selected_setting+1);
			}
		}
		if($key == $players[$clientID]->keybindings["DROP"])
		{
			$players[$clientID]->request('drop');
		}
		if($key == $players[$clientID]->keybindings["ACTION"])
		{
			$players[$clientID]->performAction();
		}
		if($key == $players[$clientID]->keybindings["SET_WAYPOINT"])
		{
			$players[$clientID]->setWaypoint();
		}
		if($key == $players[$clientID]->keybindings["USE_HEALTHPOTION"])
		{
			$players[$clientID]->useHealthpot();
		}
		if($key == $players[$clientID]->keybindings["USE_MANAPOTION"])
		{
			$players[$clientID]->useManapot();
		}
	}
	
	if($key == $players[$clientID]->keybindings["ESCAPE"])
	{
		$players[$clientID]->escape();
	}

	if($key == $players[$clientID]->keybindings["SPACE"])
	{
		if(file_exists(dirname(__FILE__) . "/dev"))
		{
			if($players[$clientID]->state == "lobby")
			{
				unsetLobby();
			}
		}
		if($players[$clientID]->show_settings)
		{
			$players[$clientID]->changeSetting();
		}
		if($players[$clientID]->in_shop)
		{
			$players[$clientID]->performMenuAction();
		}
	}

	if($key == $players[$clientID]->keybindings["SHOW_SETTINGS"])
	{
		if(!$players[$clientID]->show_settings)
		{
			$players[$clientID]->displaySettings();
		} else {
			$players[$clientID]->escape();
		}
	}

	bigBroadcast();
	}
}

function chat($clientID, $message)
{
	global $Server, $players, $allow_cheats, $allow_map_cheats, $massive, $vacant_rooms, $mobs, $single_player_mode, $start_time;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}

	if(file_exists(dirname(__FILE__) . "/dev"))
	{
		$allow_cheats = true;
		$allow_map_cheats = true;
	}
	$msg = ['type' => 'message', 'message' => $message, 'name' => $players[$clientID]->name];
	if($players[$clientID]->requestVar == null)
	{
		if(count($message) > 0 && $message != "\r")
		{
			if($single_player_mode == true)
			{
				if (strpos($message, 'time') !== false) 
				{
					status($clientID, "You've currently spent " . (round(microtime(true)) - $start_time) . " seconds playing.");
				}
			}
			if(substr($message, 0, 1) == "!") // This is a command.
			{
				preg_match("~!(.*?) ~", $message, $cmd);
	 			$cmd = $cmd[1];
	 			$arg = substr($message, strpos($message, " ") + 1);
				if($cmd == "cheats")
				{
					if($allow_cheats && $players[$clientID]->cheats == false)
					{
						$players[$clientID]->cheats = true;
						status($clientID, "Cheats are now enabled – please know that these can crash the server.", "#5CCC6B");
					} elseif($allow_cheats && $players[$clientID]->cheats == true)
					{
						$players[$clientID]->cheats = false;
						status($clientID, "Cheats are now disabled.", "#ff5c5c");
					}elseif(!$allow_cheats)
					{
						status($clientID, "Cheats are not allowed on this server.", "#ff5c5c");
					}
				} else {
					if($allow_cheats)
					{
						switch ($cmd) {
							case 'restart':
								restartServer();
								break;
							case 'slow':
								if(isset($arg[0]))
								{
									$arg = explode(" ", $arg);
									$arg[0] = preg_replace('/\s+/', '', $arg[0]);
									$arg[1] = preg_replace('/\s+/', '', $arg[1]);
									if(is_numeric($arg[0]) && is_numeric($arg[1]))
									{
										$arg[0] = (int)$arg[0];
										$arg[1] = (int)$arg[1];
										$players[$clientID]->slow($arg[0], $arg[1], $players[$clientID]);
									} else {
										status($clientID, "Not a number.");
									}
								} else {
									status($clientID, "The \"slow\" cheat works like this: \"!freeze amount_of_seconds percentage\".");
								}
								break;							
							case 'freeze':
								if(isset($arg[0]))
								{
									$arg = explode(" ", $arg);
									$arg[0] = preg_replace('/\s+/', '', $arg[0]);
									if(is_numeric($arg[0]))
									{
										$arg[0] = (int)$arg[0];
										$players[$clientID]->freeze($arg[0], $players[$clientID]);
									} else {
										status($clientID, "Not a number.");
									}
								} else {
									status($clientID, "The \"freeze\" cheat works like this: \"!freeze amount_of_seconds\".");
								}
								break;							
							case 'full':
								$players[$clientID]->curmana = $players[$clientID]->maxmana;
								$players[$clientID]->curhp = $players[$clientID]->maxhp; 
								$players[$clientID]->curstamina = $players[$clientID]->maxstamina;
								break; 
							case 'coins':
								if(isset($arg[0]))
								{
									$arg = explode(" ", $arg);
									$arg[0] = preg_replace('/\s+/', '', $arg[0]);
									if(is_numeric($arg[0]))
									{
										$arg[0] = (int)$arg[0];
										$players[$clientID]->coins = $players[$clientID]->coins + $arg[0];
									} else {
										status($clientID, "Not a number.");
									}
								} else {
									status($clientID, "The \"coins\" cheat works like this: \"!coins amount_of_coins\".");
								}
								break;
							case 'levelup':
								if(isset($arg[0]))
								{
									$arg = explode(" ", $arg);
									$arg[0] = preg_replace('/\s+/', '', $arg[0]);
									if(is_numeric($arg[0]))
									{
										$arg[0] = (int)$arg[0];
										for ($i=0; $i < $arg[0]; $i++) { 
											$players[$clientID]->curxp = $players[$clientID]->maxxp;
											$players[$clientID]->levelUp();
										}
									} else {
										status($clientID, "Not a number.");
									}
								} else {
									status($clientID, "The \"levelup\" cheat works like this: \"!levelup amount_of_levels_to_gain\".");
								}

								break;
							case 'grant':

								if(isset($arg[0]))
								{
									$arg = explode(" ", $arg);
									$arg[0] = preg_replace('/\s+/', '', $arg[0]);
									if(class_exists($arg[0]))
									{
										$newitem = eval("return new " . $arg[0] . "();");
										if(isset($arg[1]) && is_numeric((int)$arg[1]))
										{
											$arg[1] = (int) $arg[1];
											for($i = 0; $i < $arg[1]; $i++)
											{
												$players[$clientID]->addToInventory($newitem, false, false);
												$newitem->created($players[$clientID]);
											}
										} else {
											$players[$clientID]->addToInventory($newitem, false, false);
											$newitem->created($players[$clientID]);
										}
									} else {
										status($clientID, "Item does not exist.");
									}
								} else {
									status($clientID, "The \"grant\" cheat works like this: \"!grant itemClassToSpawn\". E.g. \"!grant fireScroll\"");
								}
								break;
							case 'lkill': //Kill a legendary
								$players[$clientID]->killed(new ezorvio());
								break;
							case 'killkali':
								foreach($mobs as $mob)
								{
									if($mob->name == "Kali the King of Thieves")
									{
										$mob->die($players[$clientID]);
										break;
									}
								}
								break;
							case 'tile':
								if($allow_map_cheats)
								{
									$arg = explode(" ", $arg);
									if(isset($arg[1]))
									{
										try {
											/*$arg[1] = ucfirst($arg[1]);
											if(class_exists($arg[1]))
											{*/
												$newtile = eval("return new " . ucfirst($arg[1]) . ";");
											/*} else {
												status($clientID, "Tile does not exist.");
												break;
											}*/
											if($arg[0] == "u")
											{
												setTile($players[$clientID]->x, $players[$clientID]->y - 1, new Tile($newtile));
											} elseif($arg[0] == "d")
											{
												setTile($players[$clientID]->x, $players[$clientID]->y + 1, new Tile($newtile));	
											} elseif($arg[0] == "l")
											{
												setTile($players[$clientID]->x - 1, $players[$clientID]->y, new Tile($newtile));
											} elseif($arg[0] == "r")
											{
												setTile($players[$clientID]->x + 1, $players[$clientID]->y, new Tile($newtile));
											} else
											{
												status($clientID, "The \"tile\" cheat works like this: \"!tile direction tiletospawn\".");
											}
											
										} catch (Exception $e) {
											status($clientID, "The \"tile\" cheat works like this: \"!tile direction tiletospawn\".");
										}
									}else{
										status($clientID, "The \"tile\" cheat works like this: \"!tile direction tiletospawn\".");
									}
								} else {
									status($clientID, "Map cheats not allowed.");
								}

								break;
							case 'teleport':
								$arg = explode(" ", $arg);
								echo("teleport:\n");
								var_dump($arg);
								moveTile($players[$clientID]->x, $players[$clientID]->y, $arg[0], $arg[1], $players[$clientID]);
								$players[$clientID]->x = $arg[0];
								$players[$clientID]->y = $arg[1];
							case 'hold':
								if(!$players[$clientID]->hold)
								{
									$players[$clientID]->hold = true;
									status($clientID, "You're on hold.");
								} else {
									$players[$clientID]->hold = false;
									status($clientID, "You're off hold.");
								}
								break;
							case 'name':
								if($players[$clientID]->state == "lobby")
								{
									statusBroadcast($players[$clientID]->name . " changed their name to " . preg_replace('/\s+/', '', $arg) . ".", "#ffff00", false, $clientID);
									$players[$clientID]->name = preg_replace('/\s+/', '', $arg);
									status($clientID, "Your name has been set.");
								} else {
									status($clientID, "You can only set your name in the lobby.");
								}
								break;
							case 'autotimeout':
								(int)$arg = explode(" ", $arg)[0];
								$arg = preg_replace('/\s+/', '', $arg);
								if(is_numeric($arg))
								{
									status($clientID, "You will now automatically use a timeout, if you have one, when you hit " . $arg . " HP.");
									$players[$clientID]->auto_timeout = $arg;

								} else {
									status($clientID, "You have to enter a number. Enter 0 to disable auto timeout.");
								}
								break;
							case 'settings':
								$players[$clientID]->displaySettings();
								break;
							case 'time':
								if($single_player_mode == true)
								{
									status($clientID, "You've currently spent " . (round(microtime(true)) - $start_time) . " seconds playing.");
								} else {
									status($clientID, "This functions is only enabled in single player.");
								}
								break;
							default:
								status($clientID, "This cheat does not exist. Implement it in gamefunctions.php");
								break;
						}
						bigBroadcast();
					} else {
						switch ($cmd) {
							case 'time':
								if($single_player_mode == true)
								{
									status($clientID, "You've currently spent " . (microtime(true) - $start_time) . " seconds playing.");
								} else {
									status($clientID, "This functions is only enabled in single player.");
								}
								break;
							default:
								status($clientID, "Cheats are not enabled.", "#ff5c5c");
								break;
						}
						
					}
				}
			} else {
				foreach($Server->wsClients as $id => $client)
					{
							if($clientID == $id && $players[$id]->state == "lobby")
							{
								if(!$massive)
								{
									if (strpos($message, 'startgame') !== false) //If I type startgame, start game!
									{
										if($single_player_mode == true)
										{
											$start_time = round(microtime(true));
											status($clientID, "Start timestamp is " . $start_time . " seconds.");
										}
										unsetLobby();

									} else {
										$Server->wsSend($id, json_encode($msg)); //If I don't, chat out what I wrote!
									}
								} else {
									$Server->wsSend($id, json_encode($msg));
								}
							} else {
								$Server->wsSend($id, json_encode($msg));
							}
					}
				}
			}
		} else {
			if($players[$clientID]->{$players[$clientID]->requestVar . "Response"}(preg_replace('/\s+/', '', $message)))
			{
				$players[$clientID]->unsetRequest();
			}
		}
	
}

function setLobby($clientID)
{
	global $Server, $players;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}

	$playrs = [];
	foreach ($players as $key) {
		if($key->name != null)
		{
			$playrs[$key->clientid] = ["name" => $key->name, "ready" => $key->ready]; 
		}
	}
	$msg = ["type" => "lobby", "players" => $playrs];
	$players[$clientID]->state = "lobby";
	foreach($players as $key)
	{
		if($key->state == "lobby")
		{
			$Server->wsSend($key->clientid, json_encode($msg));
		}
	}

}

function unsetLobby()
{
	global $Server, $players, $ready, $vacant_rooms, $safe_rooms;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}

	$ready = true;
	foreach($players as $player)
	{
		$player->state = "game";
		if($player->name == "___tick")
		{
			$xcoord = -1;
			$ycoord = -1;
			$player->x = $xcoord;
			$player->y = $ycoord;
			//$player->invincible(86400, $player);
			$player->maxhp = 1000000;
			$player->curhp = 1000000;

		} else {
			$room = $safe_rooms[array_rand($safe_rooms, 1)];
			$xcoord = rand($room["_x1"], $room["_x2"]);
			$ycoord = rand($room["_y1"], $room["_y2"]);
			setTile($xcoord, $ycoord, $player);
			$player->x = $xcoord;
			$player->y = $ycoord;
		}
		
		


	}
		foreach($Server->wsClients as $id => $client) {
			$Server->wsSend($id, json_encode(["type" => "unsetLobby"]));
	}
	bigBroadcast();

}

function mapPart($clientID, $receivedMappart)
{
	/*
		Allows us to send the map in chunks from client to server.
		This is necessary because the socket connection doesn't allow us to send maps
		with more than approximately 5000 tiles.

		Pass the following in $receivedMappart:
		$receivedMappart = ["map" => [...], "part" => $currentPart, "endpart" => $theFinalPart];
	*/
		return;
	global $map, $mapset;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$receivedMap = $receivedMappart["map"];
	if(!$mapset)
	{
		foreach($receivedMap as $key => $value) {
	        $parts = explode(",", $key);
	        $x = $parts[0];
	        $y = $parts[1];
	        $parsedRep = parseRepresentation($receivedMap[$key]);
	        setTile($x, $y, $parsedRep);
	    }
	    if($receivedMappart['part'] == $receivedMappart['endpart'])
	    { //Received final chunk.
	    	$mapset = true;
	    	populateMap();
		}
	}
}


function map($clientID, $receivedMap)
{

	global $map, $mapset;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	if(!$mapset)
	{
		foreach($receivedMap as $key => $value)
		{
	        $parts = explode(",", $key);
	        $x = $parts[0];
	        $y = $parts[1];
	        $map[$x][$y] = parseRepresentation($receivedMap[$key]);
	    }
	    $mapset = true;
	}
	$ix = 0;
}

function bigBroadcast()
{

	global $Server, $broadcasting, $players;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	if(!$broadcasting)
	{
		$broadcasting = true;
		foreach($Server->wsClients as $id => $client)
		{
			broadcastState($id);
		}
		$broadcasting = false;
	}
}

function spawnMob($mob, $x, $y)
{
	global $map, $mobs;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	array_push($mobs, $mob);
	$mob = end($mobs);
	$mob->x = $x;
	$mob->y = $y;
	setTile($x, $y, $mob);

}

function checkMobs()
{
	global $map, $players, $mob_checking;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	if(!$mob_checking)
	{
		$mob_checking = true;
		foreach($players as $player)
		{
			$ystart = $player->y + 20;
			$yend = $player->y - 20;
			$xstart = $player->x - 20;
			$xend = $player->x + 20;
			if($ystart < 0)
			{
				$ystart = 0;
			}
			if($xstart < 0)
			{
				$xstart = 0;
			}
			if(!$player->inTimeout())
			{
				$player->tick();
				prof_flag("Monster tick");
				for ($i=$yend; $i <= $ystart; $i++) {
					for($ix = $xstart; $ix <= $xend; $ix++)
					{
						if($ix >= 0 && $i >= 0)
						{
							if($map[$ix][$i] != null)
							{
								if($map[$ix][$i]->type() == "npc")
								{
									if($player->timeout_started_at != 0)
									{
										$map[$ix][$i]->lastattack = $map[$ix][$i]->lastattack + 5000;
									}
									$time_passed = microtime(true) - $map[$ix][$i]->checked;
									$time_passed = $time_passed > 0.33;
									if($map[$ix][$i]->checked == 0)
									{
										$time_passed = true;
									}
									if($time_passed)
									{
										$map[$ix][$i]->tick($players, $player);
									}
									if(property_exists($map[$ix][$i], 'dead'))
									{
										if($map[$ix][$i]->dead == true)
										{
											unset($map[$ix][$i]);
										}

									}
								}
							}
						}
					}
				}
				prof_flag("Done");
				prof_print();
				$player->timeout_started_at = 0;
			}
		}
		$mob_checking = false;
	}
	return true;
}

function realBigBroadcast()
{

	global $Server, $broadcastqueue;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	//$current = microtime(true);
	//array_push($broadcastqueue, $current);
	if(count($broadcastqueue) == 0)
	{
		foreach($Server->wsClients as $id => $client)
		{
			broadcastState($id);
		}
	} else {
		array_push($broadcastqueue, "true");
	}
}

function broadcastState($clientID)
{
	global $Server, $map, $players, $broadcastqueue;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	 if ($players[$clientID]->show_settings) {
		$msg = ["type" => "settings", "line" => $players[$clientID]->getSettings()];
		$Server->wsSend($clientID, json_encode($msg));
	} else if($players[$clientID]->in_shop)
	{
		$msg = ["type" => "settings", "line" => $players[$clientID]->getCharacterMenu()];
		$Server->wsSend($clientID, json_encode($msg));
	}
	else if($players[$clientID]->state == "lobby")
	{
		setLobby($clientID);
	} else {
		$state = getState($clientID);
		$Server->wsSend($clientID, json_encode($state));
	}
	$broadcastqueue = [];
}


function requestName($clientID)
{
	global $Server;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$message = ["type" => "requestName"];
	sleep(1);
	$Server->wsSend($clientID, json_encode($message));
}

function getState($clientID)
{
	global $players, $status, $keybindings;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$state = [];
	$state['type'] = "state";
	$state['map'] = parseMap($clientID);
	$state['player'] = $players[$clientID]->parse();
	return $state;
}

function status($clientID, $stat, $color = "#ffff00", $expectresponse = false)
{
	global $Server, $status;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$Server->wsSend($clientID, json_encode(['type' => 'status', 'status' => $stat, 'color' => $color, 'expectresponse' => $expectresponse]));
}

function statusBroadcast($message, $color = "#ffff00", $include_self = true, $player_clientid = null)
{
	global $Server;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	foreach($Server->wsClients as $id => $client)
	{
		if($include_self)
		{
			status($id, $message, $color);
		} else {
			if ( $id != $player_clientid)
			{
				status($id, $message, $color);
			}
		}
	}
}

function sendKeybindings($clientID)
{
	global $players, $max_players, $Server, $map, $ready, $massive, $playercount, $vacant_rooms, $keybindings;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$state = ["type" => "keybindings", "keybindings" => $players[$clientID]->parseKeybindings()];
	$Server->wsSend($clientID, json_encode($state));
}

function newPlayer($clientID)
{
	global $players, $max_players, $Server, $map, $ready, $massive, $playercount, $vacant_rooms, $keybindings, $starting_items;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}

	if(count($players) < $max_players)
	{
		if(!array_key_exists($clientID, $players)) //If we already have a character for this player.
		{
			$players[$clientID] = new Player($clientID);
			$state = ["type" => "keybindings", "keybindings" => $players[$clientID]->parseKeybindings()];
			$Server->wsSend($clientID, json_encode($state));
			
			if($massive)
			{
				/*setLobby($clientID);
				$players[$clientID]->request('name');
				$players[$clientID]->addToInventory(new dagger(), false, false);
				$players[$clientID]->levelUp();
				$players[$clientID]->addToInventory(new noxzirahsKiss(), false, false);
				$players[$clientID]->addToInventory(new skullbringersAxe(), false, false);*/

				$players[$clientID]->request('character');

				//$players[$clientID]->addToInventory(new dagger(), false, false);
				$playercount++;
				//updateplayercount();
				//$players[$clientID]->levelUp();
				//$players[$clientID]->levelUp();
				//$players[$clientID]->levelUp();
				//$players[$clientID]->levelUp();
				//$players[$clientID]->levelUp();
				unsetLobby();
				bigBroadcast();
			} else {
				setLobby($clientID);
				$players[$clientID]->request('name');
				foreach($starting_items as $item)
				{
					$players[$clientID]->addToInventory(new $item, false, false);
				}
				

				//$players[$clientID]->addToInventory(new healthPotion(), false, false);

			}
		} else {
			bigBroadcast();
		}
	}
	
}


function movePlayer($clientID, $key)
{
	global $players, $map, $keybindings;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	switch ($key) {
		case $players[$clientID]->keybindings['UP']:
			$players[$clientID]->move(0, -1);
			break;
		case $players[$clientID]->keybindings['DOWN']:
			$players[$clientID]->move(0, 1);
			break;
		case $players[$clientID]->keybindings['RIGHT']:
			$players[$clientID]->move(1);
			break;
		case $players[$clientID]->keybindings['LEFT']:
			$players[$clientID]->move(-1);
			break;
		case $players[$clientID]->keybindings['UP_1']:
			$players[$clientID]->move(0, -1);
			break;
		case $players[$clientID]->keybindings['DOWN_1']:
			$players[$clientID]->move(0, 1);
			break;
		case $players[$clientID]->keybindings['RIGHT_1']:
			$players[$clientID]->move(1);
			break;
		case $players[$clientID]->keybindings['LEFT_1']:
			$players[$clientID]->move(-1);
			break;
		default:
			break;
	}

}

function restartServer()
{

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	resetMap();
	newMap();

}	

function updateplayercount()
{
	global $mdoa_api_base, $playercount;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	exec('curl --data "id=1&players='.$playercount.'" '.$mdoa_api_base.'server/update > /dev/null 2>&1 &');
}

  function phonehome($character)
  {
  	global $mdoa_api_base;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	exec('curl --data "id='.$character->characterid.'&user_id='.$character->userid.'&level='.$character->level.'&maxxp='.$character->maxxp.'&curxp='.$character->curxp.'&hp='.$character->maxhp.'&mana='.$character->maxmana.'&gold='.$character->coins.'" '.$mdoa_api_base.'character/phonehome > /dev/null 2>&1 &');
	return true;
  }

function newInventoryMassive($item, $character)
{
	global $mdoa_api_base;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	exec('curl --data "id='.$character->characterid.'&item_id='.$item->id.'" '.$mdoa_api_base.'inventory/add > /dev/null 2>&1 &');
	return true;
}


function saveGame()
{
	global $safe_rooms, $rooms, $vacant_rooms, $spawnable_characters, $spawnable_mobs, $mobs, $characters;

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	file_put_contents("saves/rooms.json", json_encode($rooms));
	file_put_contents("saves/safe_rooms.json", json_encode($safe_rooms));
	file_put_contents("saves/vacant_rooms.json", json_encode($vacant_rooms));
	$character_strings = [];
	foreach($spawnable_characters as $character)
	{
		array_push($character_strings, get_class($character));
	}
	file_put_contents("saves/spawnable_characters.json", json_encode($character_strings));
	$character_strings = [];
	foreach($characters as $character)
	{
		array_push($character_strings, ["name" => get_class($character), "x" => $character->x, "y" => $character->y]);
	}
	file_put_contents("saves/characters.json", json_encode($character_strings));
	$mob_strings = [];
	foreach($spawnable_mobs as $mob)
	{
		array_push($mob_strings, get_class($mob));
	}
	file_put_contents("saves/spawnable_mobs.json", json_encode($mob_strings));
	$mob_strings = [];
	foreach($mobs as $mob)
	{
		array_push($mob_strings, ["name" => get_class($mob), "x" => $mob->x, "y" => $mob->y]);
	}
	file_put_contents("saves/mobs.json", json_encode($mob_strings));
}

function loadGame()
{

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
	$mobs = json_decode(file_put_contents("saves/mobs.json"));
	foreach($mobs as $mob)
	{
		spawnMob(new $mob->name, $mob->x, $mob->y);
	}
}
