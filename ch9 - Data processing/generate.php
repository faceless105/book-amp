<?php
//ID | Status | Item Name | Purchase Date | Processed Date | Buyer

$inventory = array();

//some seed values
$gear = array("Tent", "Sleeping Bag", "Stove", "Water Bottle", "Backpack");
$prices = array("250","55","35","12","70");
$firstNames = array("James","Mary","John","Patricia","Robert","Jennifer","Michael","Linda","William","Elizabeth","David","Barbara","Richard","Susan","Joseph","Jessica","Thomas","Sarah","Charles","Margaret","Christopher","Karen","Daniel","Nancy","Matthew","Lisa","Anthony","Betty","Donald","Dorothy","Mark","Sandra","Paul","Ashley","Steven","Kimberly","Andrew","Donna","Kenneth","Emily","George","Carol","Joshua","Michelle","Kevin","Amanda","Brian","Melissa","Edward","Deborah");
$lastNames = array("SMITH","JOHNSON","WILLIAMS","JONES","BROWN","DAVIS","MILLER","WILSON","MOORE","TAYLOR","ANDERSON","THOMAS","JACKSON","WHITE","HARRIS","MARTIN","THOMPSON","GARCIA","MARTINEZ","ROBINSON","CLARK","RODRIGUEZ","LEWIS","LEE","WALKER","HALL","ALLEN","YOUNG","HERNANDEZ","KING","WRIGHT","LOPEZ","HILL","SCOTT","GREEN","ADAMS","BAKER","GONZALEZ","NELSON","CARTER","MITCHELL","PEREZ","ROBERTS","TURNER","PHILLIPS","CAMPBELL","PARKER","EVANS","EDWARDS","COLLINS");

$inti = 0;
$records = 1000;
$inventory[] = array("ID", "Status", "Item Name", "Price", "Purchase Date", "Processed Date", "Buyer");
for($inti = 0; $inti < 1000; $inti += 1){
	//now we generate our items
	$gearNum = rand(1,(count($gear)-1));
	$record = array();
	$record[0] = rand(1000,9999);
	$record[1] = (rand(0,1000)%2 === 1 ? "Processed" : "Not Processed");
	$record[2] = $gear[$gearNum];
	$record[3] = $prices[$gearNum];
	$record[4] = date('Y-m-d',strtotime("-".$inti." hours"));
	$record[5] = ($record[1] == "Processed" ? date('Y-m-d',strtotime("now")) : "");
	$record[6] = strtoupper($firstNames[rand(1,(count($firstNames)-1))])." ".strtoupper($lastNames[rand(1,(count($lastNames)-1))]);
	$inventory[] = $record;
}

$fp = fopen('orders.csv', 'w');

foreach ($inventory as $records) {
    fputcsv($fp, $records);
}

fclose($fp);



?>
