<?php
echo "\nDungeons of Arvum Server\n\n";
echo "Loading classes...\n";
include_once('items/item.php');
include_once('items/weapons/weapon.php');
include_once('spells/spell.php');

include_all(realpath(dirname(__FILE__)));
echo "\nGenerating map.\n";