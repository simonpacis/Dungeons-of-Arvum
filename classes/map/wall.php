<?php

class Wall
{
	public $solid;
	public $representation;
	public $color;
	public function __construct()
	{
		$this->solid = true;
		$this->representation = "#";
		$this->color = "#8c8c8c";
	}
}