<?php

function spawnTick()
{
	echo "Spawning tick.";
	exec(realpath(dirname(__FILE__, 2)) . "/libs/phantomjs " . realpath(dirname(__FILE__)) . "/tick.js 127.0.0.1 > /dev/null 2>&1 &");	
}