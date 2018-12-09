<?php

include("functions.php");
include("shared.php");

$runAll = getVar("runAll");
if(!empty($runAll)){
	//crop our images
	cropImages('./rawimages/', './cropped/', 800, 600); //aspect ratio
	
	//resize our images
	resizeImages('./cropped/', './resized/', 800, 600); //max width and height
	
	//watermark our images
	watermarkImages('./resized/', './marked/', 25, 25); //margin x and margin y
}

$rawImages = reportDirectory('./rawimages/', 'Raw Images'); //be sure to leave the trailing slash on the directory
$croppedImages = reportDirectory('./cropped/', 'Cropped Images'); //be sure to leave the trailing slash on the directory
$resizedImages = reportDirectory('./resized/', 'Resized Images'); //be sure to leave the trailing slash on the directory
$watermarkedImages = reportDirectory('./marked/', 'Watermarked Images'); //be sure to leave the trailing slash on the directory

?>

<!DOCTYPE html>
<html lang="en-US">
<head><title>Chapter 12 - Image Tools</title>
<link rel="stylesheet" href="ch12.css">
</head>
<body>

<?php echo $rawImages; ?>
<?php echo $croppedImages; ?>
<?php echo $resizedImages; ?>
<?php echo $watermarkedImages; ?>

</body>
</html>
