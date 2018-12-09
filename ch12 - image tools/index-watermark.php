<?php

/*
Chapter 12 - Image Tools
*/

include("functions.php");
include("shared.php");

//watermark our images
watermarkImages('./rawimages/', './marked/', 800, 600);

$rawImages = reportDirectory('./rawimages/', 'Raw Images'); //be sure to leave the trailing slash on the directory
$resizedImages = reportDirectory('./marked/', 'Watermarked Images'); //be sure to leave the trailing slash on the directory



?>

<!DOCTYPE html>
<html lang="en-US">
<head><title>Chapter 12 - Image Tools</title>
<link rel="stylesheet" href="ch12.css">
</head>
<body>

<?php echo $resizedImages; ?>

<?php echo $rawImages; ?>

</body>
</html>
