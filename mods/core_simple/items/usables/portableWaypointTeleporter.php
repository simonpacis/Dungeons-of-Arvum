<?php

class portableWaypointTeleporter extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Ezorvio's Stone";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0041";
		$this->curuses = 3;
		$this->maxuses = 3;
		$this->description = $this->name . " will teleport you to your waypoint. 3 uses.";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		if($thisplayer->waypoint_x != -1)
			{
				if(movePlayerTile($thisplayer->x, $thisplayer->y, $thisplayer->waypoint_x, $thisplayer->waypoint_y, $thisplayer))
				{
					$thisplayer->x = $thisplayer->waypoint_x;
					$thisplayer->y = $thisplayer->waypoint_y;
					$thisplayer->escape();
					$thisplayer->unsetActionTarget();
					status($thisplayer->clientid, $this->name . " magically teleports you to your waypoint.", "#ff8000");
					return true;
				} else {
					if(movePlayerTile($thisplayer->x, $thisplayer->y, $thisplayer->waypoint_x+1, $thisplayer->waypoint_y+1, $thisplayer))
					{
						status($thisplayer->clientid, $this->name . " magically teleports you to your waypoint.", "#ff8000");
					} else {
						status($thisplayer->clientid, $this->name . " cannot teleport you right now. Someone must be at your waypoint.", "#ff8000");
					}
					return false;
				}
			} else {
				status($thisplayer->clientid, "You have not set a waypoint.", "#ff8000");
				return false;
			}
		return false;
	}

	public function created($thisplayer)
	{
		return true;
	}

}