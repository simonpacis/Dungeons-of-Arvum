<?php

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
        		echo "Loaded: " . $path . "\n";
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