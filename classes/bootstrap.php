<?php
echo "\nDungeons of Arvum Server\n\n";
echo "Loading classes...\n";
include_once('items/item.php');
include_once('items/weapons/weapon.php');
include_once('spells/spell.php');


include_all(realpath(dirname(__FILE__)));
echo "\nGenerating map.\n";

include('population.php');
include('gamestate.php');
include('gamefunctions.php');
include('tick/tick_spawn.php');

include_once('mods.php');
foreach($active_mods as $mod)
{
    include_all(realpath(dirname(__DIR__, 1)) . "/mods/".$mod, false);
}