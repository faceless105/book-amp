<?php

class appliance{

	public $hasPower = false; //if it's plugged in, yes this is a modern appliance
	public $turnedOn = false; //if the device is turned on
	public $name; //this will be a human friendly name
	
	//create a constructor method. This will just receive some initial variables when we create this class
	public function __construct($power=false, $on=false, $name=''){
		$this->hasPower = $power;
		$this->turnedOn = $on;
		$this->name = $name;
	}
	
	//get functions
	public function getPowerStatus(){
		return $this->hasPower;
	}
	
	public function getTurnedOnStatus(){
		return $this->turnedOn;
	}
	
	public function getName(){
		return $this->name;
	}

	//set functions
	public function setPowerStatus($power){
		$this->hasPower = $power;
	}
	
	public function setTurnedOnStatus($on){
		$this->turnedOn = $on;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	//action functions
	public function status(){
		$status['power'] = $this->hasPower;
		$status['on'] = $this->turnedOn;
		$status['name'] = $this->name;
		return $status;
	}
}

?>
