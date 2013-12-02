<?php
class Fee {
	private $ID;
	private $description;
	private $amount;
	private $groupBuy_ID;
	
	function set_ID($new) {
		$this->ID = $new;
	}
	function get_ID() {
		return $this->ID;
	}
	function set_description($new) {
		$this->description = $new;
	}
	function get_description() {
		return $this->description;
	}	
	function set_amount($new) {
		$this->amount = $new;
	}
	function get_amount() {
		return $this->amount;
	}	
	function loadMultiple($results) {
		$fees = array();
		$x=0;
		if ($results != null) {
			foreach ($results as $row) {
				$fee = Fee::mapRow($row);
		 		$fees[$x]=$fee;
		 		$x++;
			}
		}		
		return $fees;
	}
	
	function mapRow ($row) {
		$fee = new Fee();
		$fee->set_ID($row["fee_ID"]);
	 	$fee->set_description($row["description_txt"]);
	 	$fee->set_amount($row["amount_int"]);
	 	$fee->set_vendor($row["groupBuy_ID"]);
		return $fee;
	}
	
	function load($results) {
		$fees = Fee::loadMultiple($results);
		return $fees[0];
	}	
	
}