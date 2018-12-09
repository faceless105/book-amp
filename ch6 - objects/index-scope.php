<?php

/*
Chapter 6 - Objects
Goal: Demonstrate how objects work. Show the difference between extends and implements
*/

require("class.appliance.php");
require("class.dishwasher.php");
require("class.portabledishwasher.php");

//now lets create a few objects that extend others
$dishwasher = new dishwasher(true, true, "Dish Washer", 8);
$status = $dishwasher->status();
print_r($status);

echo "<br>\n<br>\n";

//rename it
$dishwasher->name = "Commercial Dish Washer";
$status = $dishwasher->status();
print_r($status);

echo "<br>\n<br>\n";

//extend it a bit deeper
$portabledishwasher = new portabledishwasher(true, true, "Portable Dish Washer", 2);
$status = $portabledishwasher->status();
print_r($status);

?>
