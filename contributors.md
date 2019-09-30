# Want to help?

You're more than welcome to make any changes to the code and request a PR, then we can talk about it. But here are some specific things that need looking at:

## The raycasting code

There's no FOV in DoA, but whenever you're going to use a weapon or a spell it happens within a radius. This was some of the earliest code written for DoA. At the moment, this radius penetrates walls, doors and everything, so you can hit stuff you shouldn't be able to hit. I'm not good at these types of things, but here's the current implementation, with comments. Only cubed radius' are supported at the moment.

```php
$ystart = $thisplayer->y + $radius_var_2; //This is the start of the cubed radius' y-coordinate. $radius_var_2 would be e.g 5, which would mean it's a 5 tiles radius. Same apploies for the other radius_var's.
$yend = $thisplayer->y - $radius_var_2; //This is the end of the cubed radius' y-coordinate.
$xstart = $thisplayer->x - $radius_var_1; //This is the start of the cubed radius' x-coordinate.
$xend = $thisplayer->x + $radius_var_1; //This is the end of the cubed radius' x-coordinate.

for ($i=$yend; $i <= $ystart; $i++) { //We iterate through every tile on the y-axis starting at the $yend coordinate, ending at the $ystart coordinate.
	$wall = false; //Thought this variable might be useful for raycasting. It does nothing at the moment.
	$floor = false; //Thought this variable might be useful for raycasting. It does nothing at the moment.
	for($ix = $xstart; $ix <= $xend; $ix++) //We iterate through every tile on the x-axis for this y-coordinate. Starting at the $xstart coordinate, ending at the $xend coordinate.
	{
		if($map[$ix][$i] != null) //If there's even a tile here.
		{
			if($map[$ix][$i]->representation() != "@") //If that tile is not another player.
			{
				if($map[$ix][$i]->representation() != "#") { //If that tile is not a wall.
					$floor = true; //Useless variable. But, since it's not a wall, we consider it a floor. Essentially a non-solid, not a floor.
					$map[$ix][$i]->setColor($thisplayer->clientid, $color);	//Since we're painting the tiles so that the entire radius receives a certain color, we call the setColor function on this particular tile.
					$thisplayer->radiustiles[$ix][$i] = "true"; //This is used to unset the radius later. Every tile that is painted must be added to this array. [$ix] is y-coordinate, [$i] is x-coordinate.
				} else {
					$wall = true;//Useless variable.
				}
			}
		}
	}
	if(!$floor && $wall)
	{ // Some kind of raycasting has to be done, so it doesn't create radius on other side of wall.
		
	}
	$wall = false; //Useless variable.
	$floor = false; //Useless variable.
}

```

The code lives in many places, but take a look in the *weapon.php* file, in the "create_radius" function, and try to change that implementation. That's the code used for all weapons. Ideally it's going to be moved to helpers.php, so the same code is used everywhere.