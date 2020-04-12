<?php

class Fjallrung extends Weapon
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $maxuses;
	public $curuses;
	public $description;
	public $level;
	public function __construct()
	{
		$this->name = "Fjallrung";
		$this->color = "#ff8000";
		$this->id = "0001";
		$this->rarity = "legendary";
		$this->description = "Fjallrung damages all players, excluding yourself, a random amount between 320 and 420.";
		$this->maxuses = 1;
		$this->curuses = $this->maxuses;
		$this->level = 16;
	}

	public function use($thisplayer)
	{
		global $players;
		statusBroadcast("In the distance you hear a sound, as if a voice screaming \"FJALLRUNG!\".", "#ff8000", false, $thisplayer->clientid);
		status($thisplayer->clientid, "From the sword in your hand a loud boom emanates. It screams \"FJALLRUNG!\".", "#ff8000");
		foreach($players as $player)
		{
			if($player->clientid != $thisplayer->clientid)
			{
				$damage = rand(320, 420);
				$player->damage($damage, "magical");
			}
		}
		return true;
		
	}
}
