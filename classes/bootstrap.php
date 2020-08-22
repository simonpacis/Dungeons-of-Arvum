<?php
echo "\nDungeons of Arvum Server\n\n";
echo "Loading classes...\n";
include_once('classes/item.php');
include_once('classes/weapon.php');
include_once('classes/spell.php');
include_once('classes/Armor.php');
include_once('classes/Mob.php');
include_once('classes/Character.php');
include_once('classes/Shop.php');
include_all(realpath(dirname(__FILE__)));

include_once('population.php');

include_once('mods.php');
echo "\nLoading mods...\n";

foreach($active_mods as $mod)
{
	echo "\nLoading mod \"".$mod."\"\n";
	include_once(realpath(dirname(__DIR__, 1)) . "/mods/".$mod."/bootstrap.php");
}


include_once('gamestate.php');
include_once('gamefunctions.php');
include_once('tick/tick_spawn.php');

