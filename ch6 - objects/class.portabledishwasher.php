<?php

class portabledishwasher extends dishwasher{

	public $capacity;
	
	//create a constructor method. This will just receive some initial variables when we create this class
	public function __construct($power=false, $on=false, $name='', $capacity=''){
		$this->hasPower = $power;
		$this->turnedOn = $on;
		$this->name = $name;
		$this->capacity = $capacity;
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
}

?>
