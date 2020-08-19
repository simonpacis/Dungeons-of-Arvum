<?php

class bowyer extends Character
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
		$this->name = "Britta the Bowyer";
		$this->representation = "B";
		$this->solid = true;
		$this->color = "#ff33cc";
		$this->x = 0;
		$this->y = 0;
		$this->action_text = "Talk to";
	}


	public function action($thisplayer)
	{
		$thisplayer->in_shop = true;
		status($thisplayer->clientid, $this->name . ": \"Bring me yew and I will craft for you.\"", "#ffff00");

	}


	public function getMenu($thisplayer)
	{
		$strings = [];
		$options = [];
		$lines = [];
		//array_push($options, ["text" => "Show function next to name: " . $funcdesc]);

		$thisplayer->max_settings = 0;
		array_push($lines, ["text" => $this->name]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "%c{white}[X] Britta's Longbow (5 x Yew Sticks)"]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"space\" to select."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"escape\" to leave."]);
		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
		if($thisplayer->isInInventory("0055"))
		{
			foreach($thisplayer->inventory as $item)
			{
				if($item->id == "0055")
				{
					if($item->curuses >= 5)
					{
						$thisplayer->addToInventory(new brittasLongBow());
						$item->spend($thisplayer, 5);
					}
				}
			}
		} else {
			status($thisplayer->clientid, $this->name . ": \"You need 5 x Yew Sticks for me to craft this weapon for you.\"", "#ffff00");
		}
	}

}
