<?php

echo "Documentation generation for Dungeons of Arvum.\n";
$predefinedClasses = get_declared_classes();
include('config.php');
include_once('helpers.php');
$orgpath = realpath(dirname(__FILE__));
$orgpath = explode("/", $orgpath);
array_pop($orgpath);
$orgpath = implode("/", $orgpath);




include_once($orgpath . '/classes/item.php');
include_once($orgpath . '/classes/weapon.php');
include_once($orgpath . '/classes/spell.php');
include_once($orgpath . '/classes/Armor.php');
include_once($orgpath . '/classes/Character.php');
include_once($orgpath . '/classes/Mob.php');
include_once($orgpath . '/classes/player.php');
include_once($orgpath . '/classes/Shop.php');
include_once($orgpath . '/classes/tile.php');

include_all($orgpath . "/mods/core/items", false);
include_all($orgpath . "/mods/core/npcs", false);
include_all($orgpath . "/mods/core/spells", false);

function getItem($min_rarity = "common", $max_rarity = "legendary", $limited_only = false, $generic_only = false, $loot_chance = 1, $potions_only = false)
{
	$arr = [$min_rarity, $max_rarity, $limited_only, $generic_only, $loot_chance, $potions_only];
	return [$arr, "Loot with rarity between " . $min_rarity . " and " . $max_rarity];
}

include('items.php');
include('spells.php');
include('mobs.php');
echo "\n";
/*echo "\nDungeons of Arvum Server\n\n";
echo "Loading classes...\n";
include_once('items/item.php');
include_once('items/weapons/weapon.php');
include_once('spells/spell.php');

include_all(realpath(dirname(__FILE__)));
echo "\nGenerating map.\n";*/