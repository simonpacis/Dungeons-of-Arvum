<?php

class Tile
{
	public $object;
	public $playercolors = [];
	public function __construct($object)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->object = &$object;
	}

	public function solid()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		return $this->object->solid;
	}

	public function representation()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		return $this->object->representation;
	}

	public function type()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if(method_exists($this->object, 'type'))
		{
			return $this->object->type();
		} else {
			return "unknown";
		}
	}

	public function color($player = null)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if($player != null)
		{
			$player = $player->clientid;
			
			if(isset($this->playercolors[$player]))
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
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		$this->playercolors[$clientid] = $color;
		return $this->color($clientid);
	}

	public function resetColor($clientid)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		unset($this->playercolors[$clientid]);
		return true;
	}

	public function pickup($player)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if(method_exists($this->object,'pickup'))
		{
			$this->object->pickup($player);
		}
		return true;
	}

	public function setOnTile()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
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
