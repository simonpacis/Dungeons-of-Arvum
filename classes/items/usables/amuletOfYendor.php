<?php

class amuletOfYendor extends Item
{
	public $name;
	public $id;
	public $color;
	public $rarity;
	public $description;
	public function __construct()
	{
		$this->name = "Amulet of Yendor";
		$this->color = "#ff8000";
		$this->rarity = "legendary";
		$this->id = "0048";
		$this->minprice = 2147383647;
		$this->maxprice = 2147383647;
		$this->level = 1;
		$this->description = "You've found the Amulet of Yendor. You can now leave the dungeon, to live happily ever after!";
		parent::__construct();
	}

	public function use($thisplayer)
	{
		$thisplayer->action_target = $this;
		$thisplayer->in_shop = true;
		return false;
	}

	public function created($thisplayer)
	{
		global $single_player_mode, $start_time, $end_time;
		if($single_player_mode == true)
		{
			$end_time = round(microtime(true));
			echo "\nEnd timestamp is " . $end_time;
			echo "\nTotal time spent from start to finish is: " . ($end_time - $start_time) . " seconds.";
		}
		$thisplayer->action_target = $this;
		$thisplayer->in_shop = true;
		return true;
	}

	public function getMenu($thisplayer)
	{
		$shop = $this;
		$strings = [];
		$options = [];
		$lines = [];

		/*$i = 0;
		$thisplayer->max_settings = 2;
		for($i = (ceil(($thisplayer->selected_setting+1)/5)); $i < (ceil(($thisplayer->selected_setting+1)/5)) + 5; $i++)
		{
			if(($i-1) <= $thisplayer->max_settings)
			{
					if($thisplayer->selected_setting == ($i-1))
					{
						$options[$i]["text"] = "%c{white}[X] %c{" . $this->stock[$i-1]->color . "}" . $this->stock[$i-1]->name . "%c{white} (" . $this->stock[$i-1]->price . "gp)";
					} else {
						$options[$i]["text"] = "%c{white}[ ] %c{" . $this->stock[$i-1]->color . "}" . $this->stock[$i-1]->name . "%c{white} (" . $this->stock[$i-1]->price . "gp)";
					}
				}
		}*/

		array_push($lines, ["text" => "Congratulations!"]);
		array_push($lines, ["text" => "You've succesfully won"]);
		array_push($lines, ["text" => "Dungeons of Arvum SP!"]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "You're done!"]);

		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
			status($thisplayer->clientid, "You've won!");
	}



}