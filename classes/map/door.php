<?php

class Door
{
	public $solid;
	public $representation;
	public $color;
	public function __construct()
	{
		$this->solid = false;
		$this->representation = "+";
		$this->color = "#fff";
		$this->set_on_tile = true;
	}
}