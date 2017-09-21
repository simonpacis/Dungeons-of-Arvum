<?php

$ip = "0.0.0.0"; //Leave this as-is for almost all use cases. Change it if you know what you're doing.
$port = 9300;

$max_players = 4;

$map_width = 400;
$map_height = 400;

$generate_new_map = false; //Set to false if you want to load a map from pre-existing map.txt and rooms.txt files in the "libs" folder.

$display_width = 41; //Default: 41 – Only touch this if you're using a custom client.
$display_height = 21; //Default: 21 – Only touch this if you're using a custom client.

$allow_cheats = false; //Please know that cheats can crash the server.