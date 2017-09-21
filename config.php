<?php

$ip = "0.0.0.0"; //Leave this as-is for almost all use cases. Change it if you know what you're doing.
$port = 9300;

$max_players = 4;

$map_width = 400;
$map_height = 400;

$generate_new_map = false; //Set to false if you want to load a map from pre-existing map.txt and rooms.txt files in the "libs" folder.

/*
	In-game specific configuratons
*/

$default_auto_timeout = 4; //The default HP at which a player will automatically use a timeout. Can be changed by the individual player. Set to 0 to disable as default, or -1 to disable the auto timeout functionality completely, so that no player can enable it for themselves.


// Obscure configurations below

$display_width = 41; //Default: 41 – Only touch this if you're using a custom client.
$display_height = 21; //Default: 21 – Only touch this if you're using a custom client.

$allow_cheats = false; //Please know that cheats can crash the server.