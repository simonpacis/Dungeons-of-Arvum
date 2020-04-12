<?php

class Shop extends Character
{

	public $action_text = "Open shop";
	public $stock_set = false;

	public function action($thisplayer)
	{
		if(!$this->stock_set)
		{
			shuffle($this->selection);
			for ($i=0; $i < $this->amount_of_items; $i++) { 
				array_push($this->stock, $this->selection[0]);
				array_shift($this->selection);
			}

			$i = 0;
			foreach($this->stock as $item)
			{
				$new_item = new $item();
				$new_item->price = rand($new_item->minprice, $new_item->maxprice);
				$this->stock[$i] = $new_item;
				$i++;
			}
			$this->stock_set = true;
		}
		$thisplayer->in_shop = true;
		status($thisplayer->clientid, "Press \"Z\" to describe the items in the shop.");

	}

	public function tick()
	{
		global $map;
		
	}


	public function getMenu($thisplayer)
	{
		$shop = $this;
		$strings = [];
		$options = [];

		$i = 0;
		$thisplayer->max_settings = count($shop->stock)-1;
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
		}

		array_push($strings, ["text" => $shop->name]);
		array_push($strings, ["text" => "Item " . ($thisplayer->selected_setting+1) . " of " . count($shop->stock) . "."]);
		array_push($strings, ["text" => " "]);
		$lines = array_merge($strings, $options);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Use the arrows to move up and down"]);
		array_push($lines, ["text" => "and press \"space\" to purchase."]);
		array_push($lines, ["text" => " "]);
		array_push($lines, ["text" => "Press \"escape\" to leave shop."]);

		return $lines;
	}

	public function performMenuAction($thisplayer)
	{
		$shop = $this;
		if($thisplayer->coins >= $shop->stock[$thisplayer->selected_setting]->price)
		{
			$thisplayer->addToInventory($shop->stock[$thisplayer->selected_setting]);
			$thisplayer->coins -= $shop->stock[$thisplayer->selected_setting]->price;
			if(isset($this->infinite_stock))
			{
				if($this->infinite_stock == true)
				{
					//unset($shop->stock[$thisplayer->selected_setting]);
				} else {
					unset($shop->stock[$thisplayer->selected_setting]);
				}
			} else {
				unset($shop->stock[$thisplayer->selected_setting]);
			}
			$shop->stock = array_values($thisplayer->action_target->stock);

			$thisplayer->selected_setting = 0;
			$thisplayer->max_settings--;
			$thisplayer->in_shop = false;
			broadcastState($thisplayer->clientid);
			$thisplayer->in_shop = true;
			broadcastState($thisplayer->clientid);
		} else {
			status($thisplayer->clientid, "You cannot afford this item.");
		}
	}

}