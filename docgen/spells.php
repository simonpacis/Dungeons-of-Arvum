<?php
namespace spells;
$documentation = "# Spells in Dungeons of Arvum
  
This document is auto-generated.

## Note
Please be aware that all of these spells have to be obtained through scrolls.
";

echo "\nGenerating spell documentation.";

$orgpath = realpath(dirname(__FILE__));
$orgpath = explode("/", $orgpath);
array_pop($orgpath);
$orgpath = implode("/", $orgpath);
$scanpath = $orgpath."/classes/spells";
$files = scandir($scanpath);

$exclusions = ["Item", "Armor", "Weapon", "item", "weapon", "spell", "Spell"];
$key_exclusions = ["name", "wielded", "minprice", "maxprice", "radius_var_1", "radius_var_2", "maxuses", "curuses", "color", "id", "radius_type", "last_attack", "panel_value"];
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
		
			array_push($common, $object);
		
	}
}

function parse_object($object)
{
	global $key_exclusions;
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
	}

	//$parsed_string .= "Price: " . $object->calculate_cost();
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

usort($common, "spells\cmp");
usort($uncommon, "spells\cmp");
usort($strong, "spells\cmp");
usort($epic, "spells\cmp");
usort($legendary, "spells\cmp");

$common_documentation = "\n### Spells
";
foreach ($common as $object) {
	
	$common_documentation .= parse_object($object);
	$common_documentation .= "";
}



$documentation .= $common_documentation;

file_put_contents("wiki/Spells.md", $documentation);
