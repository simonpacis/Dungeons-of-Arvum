<?php

class Healspot
{
	public $solid;
	public $representation;
	public $color;
	public $healamount;
	public function __construct($healAmount = 0)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->solid = false;
		$this->representation = "+";
		$this->color = "#5CCC6B";
		if($healAmount == 0)
		{
			$this->healamount = rand(2, 15);
		}
	}

	public function pickup($player)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$player->heal($this->healamount);
	}
}
