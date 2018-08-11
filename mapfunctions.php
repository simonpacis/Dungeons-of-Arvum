<?php

function newMap()
{
	global $map_height, $map_width, $map, $mapset, $rooms, $generate_new_map;

	/* Running digger map generation function from rot.js – using phantomjs. Need some way to change lib based on OS server is running on, right now only macOS compatible. */
	if($generate_new_map)
	{
		if(!file_exists(dirname(__FILE__) . "/libs/phantomjs"))
		{
			$os = php_uname('s');
			if(strtolower($os) == "darwin") //macOS
			{
				echo("\nphantomjs is missing. Downloading binary for macOS. Please wait.\n");
				exec('curl -LJ -o "' .realpath(dirname(__FILE__)).'/libs/phantom.zip"' . ' https://api.github.com/repos/simonpacis/phantomjs-bins/zipball/macos');
				exec('unzip ' .realpath(dirname(__FILE__)). '/libs/phantom.zip -d ' .realpath(dirname(__FILE__)). '/libs' );
				exec('mv ' .realpath(dirname(__FILE__)). '/libs/simonpacis-phantomjs-bins-37a1dc9/phantomjs ' .realpath(dirname(__FILE__)). '/libs/phantomjs');
				echo("\nphantomjs installed. Proceeding with map generation.\n");
			} elseif(strpos(strtolower($os), 'windows') !== false) {
				echo("\nYou're on Windows. Sorry, but you're on your own in regards to getting a working phantomjs bin in here. Check out this link: http://phantomjs.org/download.html\n\n");
				die();
			} else {
				echo("\nphantomjs is missing. You're probably on a UNIX system, so let's try a Linux binary. Please wait.\n");
				exec('curl -LJ -o "' .realpath(dirname(__FILE__)).'/libs/phantom.zip"' . ' https://api.github.com/repos/simonpacis/phantomjs-bins/zipball/linux');
				exec('unzip ' .realpath(dirname(__FILE__)). '/libs/phantom.zip -d ' .realpath(dirname(__FILE__)). '/libs' );
				exec('mv ' .realpath(dirname(__FILE__)). '/libs/simonpacis-phantomjs-bins-6a04cde/phantomjs ' .realpath(dirname(__FILE__)). '/libs/phantomjs');
				echo("\nphantomjs installed. Let's hope it works. Proceeding with map generation.\n");
			}
		}
		echo "This might take a while...\n";
		exec(realpath(dirname(__FILE__)) . "/libs/phantomjs " . realpath(dirname(__FILE__)) . "/libs/dig.js ".$map_width." " .$map_height . " " . realpath(dirname(__FILE__)));	
		echo "Map generation done.\n\n";
	} else {
		echo "Loading map from file.\n\n";
	}

	$mapfile = json_decode(file_get_contents("libs/map.doafile"), true);
	$roomsfile = json_decode(file_get_contents("libs/rooms.doafile"), true);

	foreach($mapfile as $key => $value) {
	    $parts = explode(",", $key);
	    $x = $parts[0];
	    $y = $parts[1];
	    $parsedRep = parseRepresentation($mapfile[$key]);
	    setTile($x, $y, $parsedRep);
	}
	$mapset = true;
	$rooms = $roomsfile;
	populateMap();
}

function setTile($x, $y, &$object)
{
	global $map;
	$map[$x][$y] = $object;
}

function moveTile($oldx, $oldy, $newx, $newy, &$object)
{
	global $map;
	$tile = $object;
	if($newx >= 0 && $newy >= 0)
		{
			if(!$map[$newx][$newy]->solid())
			{
				$blanktile = new Tile(new Floor());
				setTile($oldx, $oldy, $blanktile);
				setTile($newx, $newy, $tile);
				return true;
			} else {
				setTile($oldx, $oldy, $tile);
				return false;
			}
	} else {
			return false;
	}
}

function movePlayerTile($oldx, $oldy, $newx, $newy, &$object)
{
	global $map;
	$tile = $object;
	if($newx >= 0 && $newy >= 0)
		{
			if(!$map[$newx][$newy]->solid()) //If not solid.
			{
				if($tile->on_tile == null)
				{
					$blanktile = new Tile(new Floor());
				} else {
					$blanktile = $tile->on_tile;
					$tile->on_tile = null;
				}
				if($map[$newx][$newy]->setOnTile())
				{
					$tile->on_tile = $map[$newx][$newy];
				}
				$oldtile = $map[$newx][$newy];
				setTile($oldx, $oldy, $blanktile);
				setTile($newx, $newy, $tile);
				$oldtile->pickup($tile); //$tile is always player in movePlayerTile.
				return true;
			} else { // If solid
				setTile($oldx, $oldy, $tile); //Make sure the player stays on old tile.
				return false; //Nope, didn't move.
			}
	} else {
			return false; //Can't move out of bounds – extra check, map shouldn't allow this either.
	}
}

function parseMap($clientid)
{

	/*
		Let's convert the big hunk of map in $map to something readable by the client.
		The client needs to know:
			x, y, representation and color
		for each tile, and that is it!
	*/

	global $map, $players, $map_width, $map_height, $display_width, $display_height;
	$player = $players[$clientid];

	$x = $player->x;
	$y = $player->y;
	$display_height = 21;

	/* TODO */
	// Fix walking to the right, and removing camera centering there.

	if(($x - ((($display_width - 1)/2))) > 0) // If approaching left of screen, don't center on player.
	{
		$startx = $x - (($display_width - 1)/2);
	} else { // Centero on player horizontally.
		$startx = 0;
	}
	if($y > 10)
	{
		$starty = $y - 10; //If not at top of map, center screen.
	} else {
		$starty = $y - ($y); //If approaching top of map, do not center screen.
	}


	$localmap = array_slice($map, $startx, $display_width); // Get the part of map we want to show player.
	$localmap = array_values($localmap); //Reset coordinates.

	$parsedMap = [];
	
	$i = 0;
	for ($xi=0; $xi < $display_width; $xi++) {
		$yi = 0;
		$y = $localmap[$xi];
		$y = array_slice($y, $starty, $display_height);
		$y = array_values($y);
		foreach ($y as $tile) {
			if($tile != null)
			{
				$tilecolor = $tile->color($player);
				
				if(isset($tile->clientid)) //If player is not me, paint it RED!
				{
					if($tile->clientid != $clientid)
					{
						$tilecolor = "#ff0000";
					}
				}
				$parsedMap[$xi][$yi] = json_encode(["rep" => $tile->representation(), "color" => $tilecolor]);
				$yi++;
			}
		}
	}
	return $parsedMap;
}

function parseRepresentation($string)
{
	if($string == "#")
	{
		return new Tile(new Wall());
	} elseif ($string == ".")
	{
		return new Tile(new Floor());
	}
}
