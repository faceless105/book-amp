<?php

/*
Chapter 13 - Debugging
Goal: Demonstrate some basic and common areas for debugging
*/

//Error Handling

//throws a warning that the file does not exist
//$fileHandler = fopen("filedoesnotexist.txt", 'r');

//suppresses the warning
//$fileHandler = @fopen("filedoesnotexist.txt", 'r');
//$thisVal = @$myArray[$index];
//var_dump($fileHandler);
//var_dump($thisVal);

//suppress the warning, halt page execution and spit out your own error message.
//$fileHandler = @fopen("filedoesnotexist.txt", 'r') or die ("Failed opening file");



echo "<br>\n<br>\n";

class LongerException extends Exception {}

try {
	//throw new Exception('I can throw exceptions further than anyone else.',999);
	throw new LongerException('My Longest Exception Yet!!',9999);
}catch (Exception $e) {
	echo 'Caught exception: '.  $e->getMessage(). "<br>\n";
	echo 'Code: '.  $e->getCode(). "<br>\n";
	echo 'File: '.  $e->getFile(). "<br>\n";
	echo 'Line: '.  $e->getLine(). "<br>\n";
}catch(LongerException $e){
	echo 'Caught Longer exception: '.  $e->getMessage(). "<br>\n";
	echo 'Code: '.  $e->getCode(). "<br>\n";
	echo 'File: '.  $e->getFile(). "<br>\n";
	echo 'Line: '.  $e->getLine(). "<br>\n";
}

echo "<br>\n<br>\n";

//timing
echo "Starting The Clock<br>\n";
$start = microtime(true);
$secs = 5;
echo "Sleeping for ". $secs ." seconds<br>\n";
sleep($secs);
echo "Checking the Clock<br>\n";
$runtime = microtime(true) - $start;
echo "Execution took ". $runtime ." seconds<br>\n";

$secs = 3;
echo "Sleeping for ". $secs ." seconds<br>\n";
sleep($secs);
echo "Checking the Clock<br>\n";
$runtime = microtime(true) - $start;
echo "Execution took ". $runtime ." seconds<br>\n";


echo "<br>\n<br>\n";

//error messages and supression
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);



?>
