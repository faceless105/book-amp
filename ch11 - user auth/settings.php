<?php

define('SHORT_URL', false); //by design domain names must have at least two dots otherwise browser will say they are invalid. when working on localhost (!) the cookie-domain must be set to "" or NULL or FALSE instead of "localhost"
define('SITE_PATH','/');
define('BASE_URL', 'http://localhost/amp/ch11/');
define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/');


?>
