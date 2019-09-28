<?php

class shardOfFjallrung3
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $maxuses;
	public $curuses;
	public $description;
	public $displayuses;
	public $level;
	public function __construct()
	{
		$this->name = "3rd Shard of Fjallrung";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->description = "Combine all three shards and get the legendary weapon \"Fjallrung\".";
		$this->maxuses = 1;
		$this->id = "0004";
		$this->curuses = $this->maxuses;
		$this->level = 1;
	}

	public function use($thisplayer)
	{
		$shards = 0;
		if($thisplayer->isInInventory("0002") and $thisplayer->isInInventory("0003") and $thisplayer->isInInventory("0004"))
		{
				$thisplayer->removeFromInventory("0002", true, false);
				$thisplayer->removeFromInventory("0003", true, false);
				$thisplayer->removeFromInventory("0004", true, false);
				statusBroadcast("In the distance you hear a sound. \"FJALLRUNG IS ALIVE!\".", "#ff8000", false, $thisplayer->clientid);
				status($thisplayer->clientid, "You combine the three shards of Fjallrung, and in your hand they come together as a shimmering sword.", "#ffff00");
				$thisplayer->addToInventory(new Fjallrung());
			} else {
				status($thisplayer->clientid, "You do not have all three shards of Fjallrung.", "#ffff00");
		}
		return false;
	}
}
