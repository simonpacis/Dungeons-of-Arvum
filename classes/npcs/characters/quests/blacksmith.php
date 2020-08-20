<?php

class blacksmith extends Character
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $action_text;


	public function __construct()
	{
		$this->name = "Queron the Blacksmith";
		$this->representation = "Q";
		$this->solid = true;
		$this->color = "#ff33cc";
		$this->x = 0;
		$this->y = 0;
		$this->action_text = "Talk to";
	}


	public function action($thisplayer)
	{
		$thisplayer->in_shop = true;
		status($thisplayer->clientid, $this->name . ": \"Bring me iron and I will smith for you.\"", "#ffff00");

	}


	public function getMenu($thisplayer)
	{
		global $keybindings;
		$strings = [];
		$options = [];
		$lines = [];
		//array_push($options, ["text" => "Show function next to name: " . $funcdesc]);

		$thisplayer->max_settings = 0;
		array_push($lines, ["text" => $this->name]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "%c{white}[X] Queron's Longsword (5 x Iron Ingot)"]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['SPACE'])."\" to select."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['ESCAPE'])."\" to leave."]);
		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
		if($thisplayer->isInInventory("0053"))
		{
			foreach($thisplayer->inventory as $item)
			{
				if($item->id == "0053")
				{
					if($item->curuses >= 5)
					{
						$thisplayer->addToInventory(new queronsLongSword());
						$item->spend($thisplayer, 5);
					}
				}
			}
		} else {
			status($thisplayer->clientid, $this->name . ": \"You need 5 x Iron Ingots for me to smith this weapon for you.\"", "#ffff00");
		}
	}

}
