<?php

$ip = "0.0.0.0"; //0.0.0.0 exposes the server at your public-facing IP address. Change this only if you know what you're doing.
$port = 9300;

$max_players = 4; //Roadmap: Additional players will be added as spectators.

$map_width = 600;
$map_height = 600;

$generate_new_map = true; //Set to false if you want to load a map from pre-existing map.doafile and rooms.doafile files in the "libs" folder.

$enable_player_movement_speed = false; // EXPERIMENTAL: Player movement speed is experimental and does not function all too well because of the tiles of the game. This will be enabled per default as soon as I get it fixed to function properly.

$profiling = false;

/*
	In-game specific configuratons
*/

$default_timeout_duration = 5; //The amount of seconds a timeout/suspension lasts for.
$default_auto_timeout = 5; //The default HP at which a player will automatically use a timeout. Can be changed by the individual player. Set to 0 to disable as default, or -1 to disable the auto timeout functionality completely, so that no player can enable it for themselves.

/*
	Key mappings. Have to match the "VK_KEY" provided by the client. Not implemented yet.


$move_up_1 = "VK_W";
$move_down_1 = "VK_S";
$move_left_1 = "VK_A";
$move_right_1 = "VK_D";
$move_up_2 = "VK_UP";
$move_down_2 = "VK_DOWN";
$move_left_2 = "VK_LEFT";
$move_right_2 = "VK_RIGHT";

$enter_timeout = "VK_R";
$swap_items = "VK_C";
$use_healthpot = "VK_Q";
$use_manapot = "VK_E";
$describe_item = "VK_Z";
$drop_item = "VK_X";
$display_settings = "VK_H";
*/

// Obscure configurations below

$display_width = 41; //Default: 41 – Only touch this if you're using a custom client.
$display_height = 21; //Default: 21 – Only touch this if you're using a custom client.

$allow_cheats = false; //Please know that cheats can crash the server.
