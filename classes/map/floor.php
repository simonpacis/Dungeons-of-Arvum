<?php

class Floor
{
	public $solid;
	public $representation;
	public $color;
	public function __construct()
	{
		$this->solid = false;
		$this->representation = ".";
		$this->color = "#8c8c8c";
	}
}