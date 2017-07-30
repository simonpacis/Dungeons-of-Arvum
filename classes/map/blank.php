<?php

class Blank
{
	public $solid;
	public $representation;
	public $color;
	public function __construct()
	{
		$this->solid = true;
		$this->representation = " ";
		$this->color = "#fff";
	}
}