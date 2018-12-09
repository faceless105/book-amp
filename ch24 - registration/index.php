<?php

/*
Chapter 24 - Register and Authenticate - with PHP and MySQL
Goal: Demonstrate a working user authentication system

*/

include('defaults.php');

$theCase = getVar("theCase");
//logincheck
loginProcessor();
//prep the content

$thePortal = thePortal($theCase);

echo $thePortal;


?>

<html>

</html>
