<?php
namespace items;
$documentation = "# Items in Dungeons of Arvum
  
This document is auto-generated.

## Rarities
[Common](#common)<br>
[Uncommon](#uncommon)<br>
[Strong](#strong)<br>
[Epic](#epic)<br>
[Legendary](#legendary)<br>

## Note
Please note that the stock in any particular store is randomly generated from a list of possibilities, so just because it says \"can be bought in\" does not mean you can always find it in that store.
";

echo "\nGenerating item documentation.";

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
	global $key_exclusions, $predefinedClasses;
	$parsed_string = "";
	$parsed_string .= "\n#### " . $object->name . "\n";
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

		$bought_in = "";

		$userDefinedClasses = array_diff(get_declared_classes(), $predefinedClasses);

		foreach ($userDefinedClasses as $class) {
				if(is_subclass_of($class, 'Shop'))
				{
					$class = new $class;
					if(isset($class->selection))
					{
						if(is_array($class->selection))
						{
							if(in_array(get_class($object), $class->selection))
							{
								if($bought_in == "")
								{
									$bought_in = "Can be bought in: ";
								}
								$bought_in .= $class->name . ", ";
							}
						}
					}
					
				}elseif (is_subclass_of($class, 'Mob')) {
					$class = new $class;
				}
				
			
		}
		if($bought_in != "")
		{
			$bought_in .= "\n<br>";
		}
		
	}
		$parsed_string .= $bought_in;
	if(isset($object->minprice))
	{
		$parsed_string .= "Price: between " . $object->minprice . " and " . $object->maxprice;
	} else {
		$parsed_string .= "Price: between " . round($object->calculate_cost()*0.8) . " and " . round($object->calculate_cost()*1.2);
	}
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

usort($common, "items\cmp");
usort($uncommon, "items\cmp");
usort($strong, "items\cmp");
usort($epic, "items\cmp");
usort($legendary, "items\cmp");

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
file_put_contents("wiki/Items.md", $documentation);
