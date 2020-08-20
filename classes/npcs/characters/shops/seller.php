<?php

class seller extends Shop
{

	public $name;
	public $x;
	public $y;
	public $representation;
	public $solid;
	public $color;
	public $stock;
	public $allowed_items;
	public $amount_of_items;

	public function __construct()
	{
		$this->name = "Friendly and Rich Wayfarer";
		$this->representation = "S";
		$this->solid = true;
		$this->color = "#ffd700";
		$this->x = 0;
		$this->y = 0;
		$this->stock = [];

	}

	public function action($thisplayer)
	{
		$thisplayer->in_shop = true;

	}

	public function tick()
	{
		
	}

	public function getMenu($thisplayer)
	{
		global $keybindings;

		$this->stock = [];
		$i = 0;
		foreach($thisplayer->inventory as $key => $item)
		{
			if(!isset($item->no_sell))
			{
				$price = round($item->minprice + (($item->maxprice - $item->minprice)/2));
				array_push($this->stock, ["index" => $i, "item" => $item, "price" => (int) $price]);

			}
				$i++;
		}
		$shop = $this;
		$strings = [];
		$options = [];

		$i = 0;
		$thisplayer->max_settings = count($shop->stock)-1;
		if($thisplayer->max_settings >= 0)
		{
			for($i = (ceil(($thisplayer->selected_setting+1)/5)); $i < (ceil(($thisplayer->selected_setting+1)/5)) + 5; $i++)
			{
				if(($i-1) <= $thisplayer->max_settings)
				{
						if($thisplayer->selected_setting == ($i-1))
						{
							$options[$i]["text"] = "%c{white}[X] Sell %c{" . $this->stock[$i-1]['item']->color . "}" . $this->stock[$i-1]['item']->name . "%c{white} (" . $this->stock[$i-1]['price'] . "gp)";
						} else {
							$options[$i]["text"] = "%c{white}[ ] Sell %c{" . $this->stock[$i-1]['item']->color . "}" . $this->stock[$i-1]['item']->name . "%c{white} (" . $this->stock[$i-1]['price'] . "gp)";
						}
					}
			}
		} else {
			$options[0]["text"] = "%c{white} There are no sellable items in your";
			$options[1]["text"] = "%c{white} inventory.";
		}

		array_push($strings, ["text" => $shop->name]);
		if(count($shop->stock) > 0)
		{
			array_push($strings, ["text" => "Item " . ($thisplayer->selected_setting+1) . " of " . count($shop->stock) . "."]);
		} else {
			array_push($strings, ["text" => " "]);
		}
		array_push($strings, ["text" => " "]);
		$lines = array_merge($strings, $options);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Use the arrows to move up and down"]);
		array_push($lines, ["text" => "and press \"".str_replace("VK_", "", $keybindings['SPACE'])."\" to sell."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"".str_replace("VK_", "", $keybindings['ESCAPE'])."\" to leave shop."]);

		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
		$shop = $this;
		$thisplayer->coins += $shop->stock[$thisplayer->selected_setting]['price'];
		$thisplayer->selected_setting = 0;
		$thisplayer->max_settings--;
		$thisplayer->in_shop = false;
		$thisplayer->removeFromInventory($shop->stock[$thisplayer->selected_setting]['index'], false, true, false, true);
		broadcastState($thisplayer->clientid);
		$thisplayer->in_shop = true;
		broadcastState($thisplayer->clientid);

	}

}