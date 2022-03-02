<?php

class manapotTile
{
	public $solid;
	public $representation;
	public $color;
	public $amount;
	public $room;
	public function __construct($amount = 1, $thisroom = null)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->solid = false;
		$this->representation = "&";
		$this->color = "#6495ED";
		$this->amount = $amount;
		$this->room = $thisroom;
	}

	public function pickup($player)
	{
		global $vacant_rooms, $rooms;
		
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		
		$room = $vacant_rooms[array_rand($vacant_rooms, 1)];
		$xcoord = rand($room["_x1"], $room["_x2"]);
		$ycoord = rand($room["_y1"], $room["_y2"]);
		setTile($xcoord, $ycoord, new Tile(new manapotTile($this->amount, $room['id'])));
		array_push($vacant_rooms, $rooms[$this->room]);
		$player->addManapot($this->amount, $this);
		//unset($this);
	}
}
