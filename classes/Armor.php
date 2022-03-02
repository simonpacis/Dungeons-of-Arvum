<?php

class Armor extends Item
{
	public function __construct()
	{

		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		parent::__construct();
	}

}
