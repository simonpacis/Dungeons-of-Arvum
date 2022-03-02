<?php

class Floor
{
	public $solid;
	public $representation;
	public $color;
	public function __construct()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->solid = false;
		$this->representation = ".";
		$this->color = "#8c8c8c";
	}
}
