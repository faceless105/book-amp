<?php

/*
Chapter 23
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
