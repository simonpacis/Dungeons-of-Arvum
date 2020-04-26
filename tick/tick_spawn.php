<?php

function spawnTick()
{
	global $players;
	$tick = false;
	foreach($players as $player)
	{
		if($player->name == "___tick")
		{
			$tick = true;
		}
	}
	echo "Spawning tick.";
	if(!$tick)
	{
		exec(realpath(dirname(__FILE__, 2)) . "/libs/phantomjs " . realpath(dirname(__FILE__)) . "/tick.js 127.0.0.1 > /dev/null 2>&1 &");	
	}
}