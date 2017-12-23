<?php

class Tile
{
	public $object;
	public $playercolors = [];
	public function __construct($object)
	{
		$this->object = &$object;
	}

	public function solid()
	{
		return $this->object->solid;
	}

	public function representation()
	{
		return $this->object->representation;
	}

	public function type()
	{
		if(method_exists($this->object, 'type'))
		{
			return $this->object->type();
		} else {
			return "unknown";
		}
	}

	public function color($player = null)
	{
		if($player != null)
		{
			if($this->playercolors[$player] != null)
			{
				return $this->playercolors[$player];
			} else {
				return $this->object->color;
			}
		} else {
			return $this->object->color;
		}
	}

	public function setColor($clientid, $color)
	{
		$this->playercolors[$clientid] = $color;
		return $this->color($clientid);
	}

	public function resetColor($clientid)
	{
		unset($this->playercolors[$clientid]);
		return true;
	}

	public function pickup($player)
	{
		if(method_exists($this->object,'pickup'))
		{
			$this->object->pickup($player);
		}
		return true;
	}

	public function setOnTile()
	{
		if(isset($this->object->set_on_tile))
		{
			if($this->object->set_on_tile)
			{
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}