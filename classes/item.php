<?php

class Item
{

	public $minprice;
	public $maxprice;

	public function __construct()
	{

		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}

		if(!isset($this->minprice))
		{
			$this->minprice = round($this->calculate_cost()*0.8);
			$this->maxprice = round($this->calculate_cost()*1.2);
		}
	}

	public function spend($thisplayer, $uses = 1)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if(isset($this->maxuses))
		{
			$this->curuses = $this->curuses - $uses;
			if($this->curuses == 0)
			{
				status($thisplayer->clientid, $this->name . " broke.", "#ffff00");
				unset($thisplayer->inventory[$thisplayer->getInventoryIndex($this)]);
				$thisplayer->inventory = array_values($thisplayer->inventory);
			}
		}
	}

	public function calculate_cost()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}

		/* Spell scrolls */
		if(isset($item->spell))
		{
			$item = $item->spell;
		} else {
			$item = $this;
		}

		/* Rarities */
		$rarity_base_ladder = ["common" => 0, "uncommon" => 25, "strong" => 75, "epic" => 175, "legendary" => 350];
		$rarity_base_cost = 0;
		if(isset($item->rarity))
		{
			$rarity_base_cost = $rarity_base_ladder[$item->rarity];
		}

		$rarity_multiplier_ladder = ["common" => 1, "uncommon" => 1.2, "strong" => 1.5, "epic" => 2, "legendary" => 3];

		$rarity_multiplier = 0;
		if(isset($item->rarity))
		{
			$rarity_multiplier = $rarity_multiplier_ladder[$item->rarity];
		}


		/* Damage

			1 damage = 5 coins

		 */

		if(isset($item->damage))
		{
			$damage_cost = $item->damage * 5;
		} else {
			$damage_cost = 0;
		}

		/* Attack speed

			1 attack per second = 5 coins

		 */

		if(isset($item->attack_speed))
		{

			$attack_speed_cost = (1/$item->attack_speed)*5;
		} else {
			$attack_speed_cost = 0;
		}


		/* Range 

			1 field = 0
			Every consecutive field = extra_range to the power of 1.5.
		 */

		if(isset($item->radius_var_1))
		{
			$range_cost = pow(($item->radius_var_1-1),1.5);
		} else {
			$range_cost = 0;
		}



		/* Shield
			1 shield = 0.5 coin


		 */

		if(isset($item->shield))
		{
			$shield_cost = round(($item->shield)*0.5);
		} else {
			$shield_cost = 0;
		}

		/* Heal
			1 hp = 0.25 coins
		 */

		if(isset($item->heal))
		{
			$heal_cost = round(($item->heal)*0.25);
		} else {
			$heal_cost = 0;
		}


		return round(($rarity_base_cost + $damage_cost + $attack_speed_cost + $range_cost + $shield_cost + $heal_cost) * $rarity_multiplier);

	}


	public function name()
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		if(isset($this->maxuses))
		{
			return $this->name . " (".$this->maxuses." uses)";
		} else {
			return $this->name;
		}
	}

	public function created($thisplayer)
	{
		if(isMethodOverridden(get_class(), __FUNCTION__))
		{
			$args = func_get_args();
			array_push($args, $this);
			return runMethodOverride(get_class(), __FUNCTION__, $args);
		}
		return true;
	}


}
