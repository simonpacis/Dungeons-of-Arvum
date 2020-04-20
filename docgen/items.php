<?php

$documentation = "# Items in Dungeons of Arvum

## Rarities
[Common](#common)<br>
[Uncommon](#uncommon)<br>
[Strong](#strong)<br>
[Epic](#epic)<br>
[Legendary](#legendary)<br>

";

echo "\n<br>  Generating item documentation.";

$orgpath = realpath(dirname(__FILE__));
$orgpath = explode("/", $orgpath);
array_pop($orgpath);
$orgpath = implode("/", $orgpath);
$scanpath = $orgpath."/classes/items";
$files = scandir($scanpath);

$exclusions = ["Item", "Armor", "Weapon", "item", "weapon"];
$key_exclusions = ["name", "wielded", "minprice", "maxprice", "radius_var_1", "radius_var_2", "maxuses", "curuses", "color", "id", "radius_type", "last_attack"];
$common = [];
$uncommon = [];
$strong = [];
$epic = [];
$legendary = [];


function ingest_object($object)
{
	global $common, $uncommon, $strong, $epic, $legendary;
	if(!isset($object->no_doc))
	{
		if($object->rarity == "common")
		{
			array_push($common, $object);
		}
		if($object->rarity == "uncommon")
		{
			array_push($uncommon, $object);
		}
		if($object->rarity == "strong")
		{
			array_push($strong, $object);
		}
		if($object->rarity == "epic")
		{
			array_push($epic, $object);
		}
		if($object->rarity == "legendary")
		{
			array_push($legendary, $object);
		}
	}
}

function parse_object($object)
{
	global $key_exclusions;
	$parsed_string = "";
	$parsed_string .= "\n#### " . $object->name . "\n<br>";
	foreach ($object as $key => $value) {
		if(!in_array($key, $key_exclusions))
		{
			if($value != null)
			{
				if(is_array($value))
				{
					$parsed_string .= ucfirst(str_replace("_", " ", $key)) . ": " . ucfirst(implode(", ", str_replace("_", " ", $value))) . "\n<br>  ";
				} elseif (is_object($value)) {
					$parsed_string .= ucfirst(str_replace("_", " ", $key)) . ": " . ucfirst(get_class($value)) . "\n<br>  ";
				}
				 else {
					$parsed_string .= ucfirst(str_replace("_", " ", $key)) . ": " . ucfirst(str_replace("_", " ", $value)) . "\n<br>  ";
				}
			}
		}
		if($key == "radius_var_1")
		{
			$parsed_string .= "Range: " . $object->radius_var_1 . "\n<br>  ";
		}
	}

	$parsed_string .= "Price: " . $object->calculate_cost() . "\n<br>  ";
	return $parsed_string;
}


function item_include_all($dir, $echo = true, &$results = array()){
	global $exclusions;
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
        	if(substr($path, -4) == ".php")
        	{
        		$value = substr_replace($value ,"", -4);
        		if(!in_array($value, $exclusions))
        		{
        			$object = new $value;
        			ingest_object($object);
        		}
        		
        	}
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            item_include_all($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

function cmp($a, $b) {
    return strcmp($a->name, $b->name);
}


item_include_all($scanpath);

usort($common, "cmp");
usort($uncommon, "cmp");
usort($strong, "cmp");
usort($epic, "cmp");
usort($legendary, "cmp");

$common_documentation = "\n### Common
";
foreach ($common as $object) {
	
	$common_documentation .= parse_object($object);
	$common_documentation .= "";

}

$uncommon_documentation = "\n### Uncommon
";
foreach ($uncommon as $object) {
	
	$uncommon_documentation .= parse_object($object);
	$uncommon_documentation .= "";

}

$strong_documentation = "\n### Strong
";
foreach ($strong as $object) {
	
	$strong_documentation .= parse_object($object);
	$strong_documentation .= "";

}

$epic_documentation = "\n### Epic
";
foreach ($epic as $object) {
	
	$epic_documentation .= parse_object($object);
	$epic_documentation .= "";

}

$legendary_documentation = "\n### Legendary
";
foreach ($legendary as $object) {
	
	$legendary_documentation .= parse_object($object);
	$legendary_documentation .= "";

}



$documentation .= $common_documentation;
$documentation .= $uncommon_documentation;
$documentation .= $strong_documentation;
$documentation .= $epic_documentation;
$documentation .= $legendary_documentation;

file_put_contents("wiki/items.md", $documentation);
