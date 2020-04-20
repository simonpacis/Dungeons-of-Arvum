<?php

echo "Documentation generation for Dungeons of Arvum.\n";
include('config.php');
include_once('helpers.php');
$orgpath = realpath(dirname(__FILE__));
$orgpath = explode("/", $orgpath);
array_pop($orgpath);
$orgpath = implode("/", $orgpath);


include_once($orgpath . '/classes/items/item.php');
include_once($orgpath . '/classes/items/weapons/weapon.php');
include_once($orgpath . '/classes/spells/spell.php');


include_all($orgpath . "/classes/", false);
include('items.php');
include('spells.php');
/*echo "\nDungeons of Arvum Server\n\n";
echo "Loading classes...\n";
include_once('items/item.php');
include_once('items/weapons/weapon.php');
include_once('spells/spell.php');

include_all(realpath(dirname(__FILE__)));
echo "\nGenerating map.\n";*/