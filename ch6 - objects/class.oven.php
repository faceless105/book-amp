<?php

class oven extends appliance implements logic{

	public $capacity;
	public $gas;
	public $electric;
	public $setTemp;
	
	//create a constructor method. This will just receive some initial variables when we create this class
	public function __construct($power=false, $on=false, $name='', $capacity='', $fuel=''){
		$this->hasPower = $power;
		$this->turnedOn = ($this->powerCheck() ? $on : false); //add the logic check that a device can't turn on without power
		$this->name = $name;
		$this->capacity = $capacity;
		
		//check our fuel type
		$this->gas = ($fuel == "gas" ? true : false);
		$this->electric = ($fuel == "electric" ? true : false);
			
	}
	
	//get functions
	public function getCapacity(){
		return $this->capacity;
	}
	
	//set functions
	public function setCapacity($capacity){
		$this->capacity = $capacity;
	}
	
	//action functions
	public function status(){
		$status = parent::status();
		//$status['power'] = $this->hasPower;
		//$status['on'] = $this->turnedOn;
		//$status['name'] = $this->name;
		$status['capacity'] = $this->capacity;
		return $status;
	}
	
	//required from our interface
	public function powerCheck(){
		//before the oven can do anything, we need to have power
		return ($this->hasPower ? true : false);
	}
}

?>
