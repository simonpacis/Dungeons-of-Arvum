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