<?php

function is_between_coords($pos_x, $pos_y, $check_x, $check_y, $xrange, $yrange = null)
{
    if($yrange == null)
    {
        $yrange = $xrange;
    }
    $ystart = floor($check_y + $yrange);
    $yend = floor($check_y - $yrange);
    $xstart = floor($check_x - $xrange);
    $xend = floor($check_x + $xrange);
    if($ystart < 0)
    {
        $ystart = 0;
    }
    if($xstart < 0)
    {
        $xstart = 0;
    }

    $in_x = ($pos_x <= $xend && $pos_x >= $xstart);
    $in_y = ($pos_y >= $yend && $pos_y <= $ystart);

    if($in_y && $in_x)
    {
        return true;
    } else {
        return false;
    }
}

function in_2d_array($array, $key, $val) {
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $val)
            return true;
    return false;
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
     * Scan the api path, recursively including all PHP files
     *
     * @param string  $dir
     * @param int     $depth (optional)
     */
function include_all($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
        	if(substr($path, -4) == ".php")
        	{
        		echo "Loaded: " . $value . "\n";
        		include_once($path);
        	}
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            include_all($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}