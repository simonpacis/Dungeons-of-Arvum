<?php

function is_between_coords($pos_x, $pos_y, $check_x, $check_y, $xrange, $yrange = null)
{

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
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

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $val)
            return true;
    return false;
}

function get_string_between($string, $start, $end){

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
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
function include_all($dir, $echo = true, $results = array(), $except = array()){

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
        	if(substr($path, -4) == ".php")
        	{
                if($echo)
                {
        		  echo "Loaded: " . $value . "\n";
                }
                if(!in_array($value, $except))
                {
                    include_once($path);
                }
        		
        	}
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            include_all($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

function callableToString($callable) {

	if(isOverridden(__FUNCTION__))
	{
		$args = func_get_args();
		return runOverride(__FUNCTION__, $args);
	}
    $refFunc = new ReflectionFunction($callable);
    $startLine = $refFunc->getStartLine();
    $endLine   = $refFunc->getEndLine();

    $f      = fopen($refFunc->getFileName(), 'r');
    $lineNo = 0;

    $methodBody = '';
    while($line = fgets($f)) {
        $lineNo++;
        if($lineNo > $startLine) {
            $methodBody .= $line;
        }
        if($lineNo == $endLine - 1) {
            break;
        }
    }
    fclose($f);

    return $methodBody;
}

function isOverridden($function_name)
{
	global $overridden_functions;
	if(isset($overridden_functions))
	{
		if(in_array($function_name, $overridden_functions))
		{
			if(function_exists('mod_'.$function_name))
			{
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function runOverride($function_name, $arguments)
{
	global $overridden_functions;
	return call_user_func_array('mod_'.$function_name, $arguments);
}

function isMethodOverridden($class_name, $function_name)
{
	global $overridden_functions;
	if(isset($overridden_functions))
	{
		if(in_array($class_name . '_' . $function_name, $overridden_functions))
		{
			if(function_exists('mod_'.$class_name.'_'.$function_name))
			{
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function runMethodOverride($class_name, $function_name, $arguments)
{
	global $overridden_functions;
	return call_user_func_array('mod_'.$class_name.'_'.$function_name, $arguments);
}
