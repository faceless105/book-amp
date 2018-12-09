<?php

include("functions.php");
include("shared.php");

//crop our images
cropImages('./rawimages/', './cropped/', 800, 600);

$rawImages = reportDirectory('./rawimages/', 'Raw Images'); //be sure to leave the trailing slash on the directory
$croppedImages = reportDirectory('./cropped/', 'Cropped Images'); //be sure to leave the trailing slash on the directory

?>

<!DOCTYPE html>
<html lang="en-US">
<head><title>Chapter 12 - Image Tools</title>
<link rel="stylesheet" href="ch12.css">
</head>
<body>

<?php echo $croppedImages; ?>

<?php echo $rawImages; ?>

</body>
</html>
