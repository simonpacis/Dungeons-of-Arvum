<?php

class Healspot
{
	public $solid;
	public $representation;
	public $color;
	public $healamount;
	public function __construct($healAmount = 0)
	{
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
		$player->heal($this->healamount);
	}
}