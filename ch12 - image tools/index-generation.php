<?php

/*
Chapter 12 - Image Tools
*/

include("functions.php");
include("shared.php");
/*
Population Distribution - As of 8/17/18
https://en.wikipedia.org/wiki/Demographics_of_the_world
Asia | 4,307,107,875 | 60.3%
Africa | 1,037,524,058 | 14.5%
Europe | 816,426,346 | 11.4%
North America | 544,620,340 | 7.6%
South America | 400,067,694 | 5.6%
Oceania | 35,426,995 | 0.5%
Antarctica | 1,169 | 0.00002%
*/
$data = array("Asia"=>4307107875, "Africa" => 1037524058, "Europe" => 816426346, "North America" => 544620340, "South America" => 400067694, "Oceania" => 35426995, "Antarctica" => 1169);

//build a pie chart
pieChartBuilder('./charts/pie-pop-dist.png', $data, 800, 600);

?>

<!DOCTYPE html>
<html lang="en-US">
<head><title>Chapter 12 - Image Tools</title>
<link rel="stylesheet" href="ch12.css">
</head>
<body>

<img src="./charts/pie-pop-dist.png">

</body>
</html>
