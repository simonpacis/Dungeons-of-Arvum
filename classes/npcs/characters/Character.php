<?php

class Character 
{

	public $room = 0;

	public function representation()
	{
		return $this->representation;
	}

	public function solid()
	{
		return true;
	}

	public function type()
	{
		if(!isset($this->type))
		{
			return "character";
		} else {
			return $this->type;
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
				return $this->color;
			}
		} else {
			return $this->color;
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
}