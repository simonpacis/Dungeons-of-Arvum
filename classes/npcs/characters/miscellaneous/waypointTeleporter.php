<?php

class waypointTeleporter extends Character
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $action_text;


	public function __construct()
	{
		$this->name = "Godrek Twistheart";
		$this->representation = "T";
		$this->solid = true;
		$this->color = "#ff33cc";
		$this->x = 0;
		$this->y = 0;
		$this->action_text = "Talk to";
	}


	public function action($thisplayer)
	{
		$thisplayer->in_shop = true;
		status($thisplayer->clientid, $this->name . ": \"I can perform many magical miracles for you, good sir. What will it be?\"", "#fff");

	}


	public function getMenu($thisplayer)
	{
		global $keybindings;
		$strings = [];
		$options = [];
		$lines = [];
		//array_push($options, ["text" => "Show function next to name: " . $funcdesc]);

		$thisplayer->max_settings = 0;
		array_push($lines, ["text" => $this->name]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "%c{white}[X] Teleport to my waypoint (100gp)"]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['SPACE'])."\" to select."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['ESCAPE'])."\" to leave."]);
		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
		if($thisplayer->coins >= 100)
		{
			if($thisplayer->waypoint_x != -1)
			{
				if(movePlayerTile($thisplayer->x, $thisplayer->y, $thisplayer->waypoint_x, $thisplayer->waypoint_y, $thisplayer))
				{
					$thisplayer->x = $thisplayer->waypoint_x;
					$thisplayer->y = $thisplayer->waypoint_y;
					$thisplayer->escape();
					$thisplayer->unsetActionTarget();
					status($thisplayer->clientid, $this->name . " magically teleports you to your waypoint.", "#ff33cc");
					$thisplayer->coins -= 100;
				} else {
					status($thisplayer->clientid, $this->name . ": \"Uh, I seem not to be able to teleport you right now. Sorry..\"", "#fff");
				}
			} else {
				status($thisplayer->clientid, "You have not set a waypoint.");
			}
		} else {
			status($thisplayer->clientid, $this->name . ": \"You do not have enough money.\"", "#fff");
		}
	}

}
