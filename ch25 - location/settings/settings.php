<?php
$database_host = "localhost";
$database_user = "root";
$database_password = "password";
$database = "playground";
//we're just going to define some constants...
define('SHORT_URL', ''); //by design domain names must have at least two dots otherwise browser will say they are invalid. when working on localhost (!) the cookie-domain must be set to "" or NULL or FALSE instead of "localhost"
define('SITE_PATH','/');
define('BASE_URL', 'http://localhost/code/ch22 - users/');
define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
?>
