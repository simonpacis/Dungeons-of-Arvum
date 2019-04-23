<?php

class noxzirahsKiss
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public $additional_health;
	public function __construct()
	{
		$this->name = "Noxzirah's Kiss";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0034";
		$this->hook = "before_monster_death";
		$this->description = "Noxzirah's Kiss will ensure that you do not die to any monster. While in inventory, you will survive your next death.";
	}

	public function use($thisplayer)
	{
		status($thisplayer->clientid, "Noxzirah's Kiss will ensure that you do not die to any monster. While in inventory, you will survive your next death.", "#ff8000");
	}

	public function runHook()
	{
		$safe_rooms = func_get_arg(0);
		$player = func_get_arg(1);
		$distances = [];
		$distance_indexes = []; 
		$i = 0;
		foreach($safe_rooms as $safe_room)
		{
			$x_distance = $safe_room['_x1'] - $player->x;
			$y_distance = $safe_room['_y1'] - $player->y;
			$combined = abs($x_distance) + abs($y_distance);
			array_push($distances, $combined);
			array_push($distance_indexes, $i);
			$i++;
		}

		array_multisort($distances, $distance_indexes);

		$room = $safe_rooms[$distance_indexes[0]];
		movePlayerTile($player->x, $player->y, ($room["_x2"]-(($room["_x2"]-$room["_x1"])/2)) + 1, ($room["_y2"]-(($room["_y2"]-$room["_y1"])/2)) + 1, $player);
		$player->x = ($room["_x2"]-(($room["_x2"]-$room["_x1"])/2)) + 1;
		$player->y = ($room["_y2"]-(($room["_y2"]-$room["_y1"])/2)) + 1;


		$player->curhp = $player->maxhp;
		$player->curshield = 0;
		status($player->clientid, "Noxzirah's Kiss ensured that " . $this->name . " did not die this time around.", "#ff8000");
		statusBroadcast("Noxzirah's Kiss ensured that " . $this->name . " did not die this time around.", "#ff8000");
		$player->removeFromInventory($this, false, true, true);
		return false;

	}
}