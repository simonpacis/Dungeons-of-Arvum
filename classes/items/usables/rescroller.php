<?php

class rescroller
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Rescroller";
		$this->color = "#a335ee";
		$this->rarity = "epic";
		$this->id = "0045";
		$this->description = $this->name . " allows you to convert an active spell back into a scroll, to be read at a later time again.";
	}

	public function use($thisplayer)
	{
		$thisplayer->request('rescroll', $this);
	}

	public function rescrollRequest($thisplayer)
	{
		status($thisplayer->clientid, "Type either \"E\" or \"Q\" to convert this spell back into a scroll. Type \"0\" to cancel.", "#ffff00", true);
		return true;
	}

	public function rescrollResponse($message, $thisplayer)
	{
		$message = ucfirst($message);
		if($message == "E")
		{
			$rescroll = new reScroll();
			$rescroll->created($thisplayer->spells[1]);
			$thisplayer->addToInventory($rescroll);
			unset($thisplayer->spells[1]);
			$thisplayer->spells = array_values($thisplayer->spells); 
			$i = 0;
			foreach($thisplayer->inventory as $item)
			{
				if($item === $this)
				{
					$thisplayer->removeFromInventory($i, false);
				}
				$i++;
			}
		}
		if($message == "Q")
		{
			$rescroll = new reScroll();
			$rescroll->created($thisplayer->spells[0]);
			$thisplayer->addToInventory($rescroll);
			unset($thisplayer->spells[0]);
			$thisplayer->spells = array_values($thisplayer->spells); 
			foreach($thisplayer->inventory as $item)
			{
				if($item === $this)
				{
					status($thisplayer->clientid, $this->name . " broke.", "#ffff00");
					$thisplayer->removeFromInventory($i, false);

				}
				$i++;
			}
		}
		return false;
	}

	public function created($thisplayer)
	{
		return true;
	}

}