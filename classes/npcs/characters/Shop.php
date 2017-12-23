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

}