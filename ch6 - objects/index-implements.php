<?php

/*
Chapter 6 - Objects
Goal: Demonstrate how objects work. Show the difference between extends and implements
*/

require("class.appliance.php");
require("interface.logic.php");
require("class.oven.php");

//now lets create a few objects that extend others
$oven = new oven(true, true, "Oven", 5, 'gas');
$status = $oven->status();
print_r($status);

echo "<br>\n<br>\n";


?>
