<?php
/*
This is where I will house the majority of our initializing and setup calls
*/

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//collect our settings
include('settings/settings.php');

//establish our connection with fields from our settings page
try{
    $conn = new PDO('mysql:dbname='.$database.';host='.$database_host.';charset=utf8', $database_user, $database_password);
	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection Error: ".$e->getMessage();
    echo "Connection Error Code: ".$e->getCode();
    exit();
}

//start adding our includes
include('functions.php');
include('location.php');



?>
