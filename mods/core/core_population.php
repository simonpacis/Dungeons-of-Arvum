<?php

$starting_items = ["dagger"];

$limited_items=[
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new theShieldgiver(),
	new legendaryLocator(),
	new legendaryLocator(),
	new legendaryLocator(),
	new legendaryLocator(),
	new legendaryLocator(),
	new legendaryLocator(),
	new legendaryLocator(),
];
$generic_items=[
	new shortBow(),
	new shortSword(),
	new longBow(),
	new pike(),
	new brandiStock(),
	new ironSpear(),
	new longSword(),
	new rapier(),
	new iceScroll(),
	new fireScroll(),
	new lightningScroll(),	
	new rescroller(),
	new ironIngot(),
	new yewSticks(),
	new chainBreastplate(),
	new chainmail(),
	new leatherArmor(),
	new platemail()
];
$potion_items = [
	/*new healthPotion(),
	new healthPotion(),
	new healthPotion(),
	new healthPotion(),*/
	new healthJug(),
	/*new manaPotion(),
	new manaPotion(),
	new manaPotion(),
	new manaPotion(),*/
	new majorManaPotion(),
	new majorManaPotion(),
	new manaJug(),
	new smallShield(),
	new smallShield(),
	new smallShield(),
	new mediumShield(),
	new mediumShield(),
	new majorShield()
];
$spawnable_mobs =[
	new archerBandit(),
	new bandit(),
	new oakOwl(),
	new wolfbat(),
	new wyvern(),
	new bannerBear(),
	new mage()
];

$limited_mobs = [
	new skullMan(),
	new noxzirah(),
	new ezorvio()
];

$spawnable_characters = [
	new dwarvenMarket(),
	new generalStore(),
	new seller(),
	new scrollStore(),
	new bowSeller(),
	new bountyHunter()
];

$limited_characters = [
	new waypointTeleporter(),
	new waypointTeleporter(),
	new waypointTeleporter(),
	new blacksmith(),
	new bowyer()
];