<?php

/*
Chapter 6 - Objects
Goal: Demonstrate how objects work. Show the difference between extends and impliments
*/

require("class.appliance.php");

//what better way to demonstrate objects than to create an object for a vague mystery appliance

//initialize our object
$toaster = new appliance(true, true, "Toaster");

//call a public function
$status = $toaster->status();
print_r($status);

//lets create another appliance
$refrigerator = new appliance(true, true, "Refrigerator");
//call a public function
$status = $refrigerator->status();
print_r($status);

//Lets access some of the functions and variables directly for the toaster
echo "<br>\n<br>\nThe thing that burns the bread is called a ". $toaster->name ."<br>\n<br>\n";

//rename it
$toaster->name = "Commercial Toaster";

echo "<br>\n<br>\nThe thing that burns the bread is called a ". $toaster->name ."<br>\n<br>\n";

//rename it
$toaster->setName("Residential Toaster");

echo "<br>\n<br>\nThe thing that burns the bread is called a ". $toaster->getName() ."<br>\n<br>\n";

//Create a new variable
$toaster->age = "7";

echo "<br>\n<br>\nThe ". $toaster->name ." is ". $toaster->age ." months old.<br>\n<br>\n";

?>
