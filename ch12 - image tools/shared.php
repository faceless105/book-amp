<?php

function cropImages($baseDir, $newDir, $aspectWidth, $aspectHeight){
	
	$aspectPctHorizontal = ($aspectWidth/$aspectHeight);
	$aspectPctVertical = ($aspectHeight/$aspectWidth);
	
	//lets get our images
	$images = glob($baseDir.'*.{jpg,png,gif}', GLOB_BRACE);
	//make sure we have our images before we loop through them
	
	if($images !== false && is_array($images) && count($images) > 0){
		foreach($images as $image) {
			
			set_time_limit(15);
			
			$dimensions = getimagesize($image);
			$filesize = filesize($image);
			$filename = explode("/",$image);
			
			//now determine if this image is horizontal or vertical
			if($dimensions[0] >= $dimensions[1]){ //horizontal or perfectly square
				if(($dimensions[0]/$dimensions[1]) != $aspectPctHorizontal){ //compare the horizontal Aspect ratio to our target aspect ratio
					//now we resize
					if(class_exists('Imagick')) { //check if imagick exists on here
						$im = new Imagick($image);
						//now lets see if we are trimming from the X or the Y to avoid adding blank space
						if($dimensions[0]*$aspectPctVertical >= $dimensions[1]){ //the X is larger, so crop that out
							$im->cropThumbnailImage(($dimensions[1]*$aspectPctHorizontal),$dimensions[1]); //crop and resize the image
							//echo "Option 1a: ". $image ." -- Old: ".$dimensions[0]." x ".$dimensions[1]." -- New: ". ($dimensions[1]*$aspectPctHorizontal) ." x ".$dimensions[1]."<br>\n";
						}
						else{ //the Y is larger, so crop that
							$im->cropThumbnailImage($dimensions[0],($dimensions[0]*$aspectPctVertical)); //crop and resize the image
							//echo "Option 2a: ". $image ." -- Old: ".$dimensions[0]." x ".$dimensions[1]." -- New: ". $dimensions[0] ." x ".($dimensions[0]*$aspectPctVertical)."<br>\n";
						}
						$im->writeImage($newDir.end($filename));
						$im->clear();
					}
					else{ //repeat using the GD library
						$im = imagecreatefromjpeg($image); //this function will change based on image types
						//now lets see if we are trimming from the X or the Y to avoid adding blank space
						if($dimensions[0]*$aspectPctVertical >= $dimensions[1]){ //the X is larger, so crop that out
							$im2 = imagecrop($im, ['x' => $dimensions[0]/2, 'y' => $dimensions[1]/2, 'width' => ($dimensions[1]*$aspectPctHorizontal), 'height' => $dimensions[1]]);
							//echo "Option 1b: ". $image ." -- Old: ".$dimensions[0]." x ".$dimensions[1]." -- New: ". ($dimensions[1]*$aspectPctHorizontal) ." x ".$dimensions[1]."<br>\n";
						}
						else{ //the Y is larger, so crop that
							$im2 = imagecrop($im, ['x' => $dimensions[0]/2, 'y' => $dimensions[1]/2, 'width' => $dimensions[0], 'height' => ($dimensions[0]*$aspectPctVertical)]);
							//echo "Option 2b: ". $image ." -- Old: ".$dimensions[0]." x ".$dimensions[1]." -- New: ". $dimensions[0] ." x ".($dimensions[0]*$aspectPctVertical)."<br>\n";
						}
						//make sure we were able to create this image
						if ($im2 !== FALSE) {
							imagejpeg($im2, $newDir.end($filename));
							imagedestroy($im2);
						}
						imagedestroy($im);
					}

				}
				else{
					copy($image, $newDir.end($filename));
				}
			}
			else{ //this is a vertical image
				if(($dimensions[0]/$dimensions[1]) != $aspectPctVertical){ //compare the vertical Aspect ratio to our target aspect ratio
					//now we resize
					if(class_exists('Imagick')) { //check if imagick exists on here
						$im = new Imagick($image);
						//now lets see if we are trimming from the X or the Y to avoid adding blank space
						if($dimensions[0] >= $dimensions[1]*$aspectPctVertical){ //the X is larger, so crop that out
							$im->cropThumbnailImage(($dimensions[1]*$aspectPctVertical),$dimensions[1]); //crop and resize the image
						}
						else{ //the Y is larger, so crop that
							$im->cropThumbnailImage($dimensions[0],($dimensions[0]*$aspectPctHorizontal)); //crop and resize the image
						}
						$im->writeImage($newDir.end($filename));
						$im->clear();
					}
					else{ //repeat using the GD library
						$im = imagecreatefromjpeg($image); //this function will change based on image types
						//now lets see if we are trimming from the X or the Y to avoid adding blank space
						if($dimensions[0] >= $dimensions[1]*$aspectPctVertical){ //the X is larger, so crop that out
							$im2 = imagecrop($im, ['x' => $dimensions[0]/2, 'y' => $dimensions[1]/2, 'width' => ($dimensions[1]*$aspectPctVertical), 'height' => $dimensions[1]]);
						}
						else{ //the Y is larger, so crop that
							$im2 = imagecrop($im, ['x' => $dimensions[0]/2, 'y' => $dimensions[1]/2, 'width' => $dimensions[0], 'height' => ($dimensions[0]*$aspectPctHorizontal)]);
						}
						//make sure we were able to create this image
						if ($im2 !== FALSE) {
							imagejpeg($im2, $newDir.end($filename));
							imagedestroy($im2);
						}
						imagedestroy($im);
					}

				}
				else{
					//there's a scenario where we can have an image here with a perfect aspect ratio already, so we just need to copy the file into the new location
					copy($image, $newDir.end($filename));
				}
			}
		}
	}
}

function resizeImages($baseDir, $newDir, $targetWidth, $targetHeight){
	
	//lets get our images
	$images = glob($baseDir.'*.{jpg,png,gif}', GLOB_BRACE);
	//make sure we have our images before we loop through them
	
	if($images !== false && is_array($images) && count($images) > 0){
		foreach($images as $image) {
			
			set_time_limit(15);
			
			$dimensions = getimagesize($image);
			$filesize = filesize($image);
			$filename = explode("/",$image);
			
			//now determine if this image is horizontal or vertical
			if($dimensions[0] >= $dimensions[1]){ //horizontal or perfectly square
				//now we resize
				if(class_exists('Imagick')) { //check if imagick exists on here
					$im = new Imagick($image);
					$im->resizeImage($targetWidth, $targetHeight, imagick::FILTER_LANCZOS, 1, false);
					$im->writeImage($newDir.end($filename));
					$im->clear();
				}
				else{ //repeat using the GD library
					$im = imagecreatefromjpeg($image); //this function will change based on image types
					$im2 = ImageCreateTrueColor($targetWidth,$targetHeight);
					imagecopyresampled($im2,$im,0,0,0,0,$targetWidth,$targetHeight,$dimensions[0],$dimensions[1]);
					//make sure we were able to create this image
					if ($im2 !== FALSE) {
						imagejpeg($im2, $newDir.end($filename));
						imagedestroy($im2);
					}
					imagedestroy($im);
				}
			}
			else{ //this is a vertical image
				//now we resize
				if(class_exists('Imagick')) { //check if imagick exists on here
					$im = new Imagick($image);
					$im->resizeImage($targetHeight, $targetWidth, imagick::FILTER_LANCZOS, 1, false);
					$im->writeImage($newDir.end($filename));
					$im->clear();
				}
				else{ //repeat using the GD library
					$im = imagecreatefromjpeg($image); //this function will change based on image types
					$im2 = ImageCreateTrueColor($targetHeight,$targetWidth);
					imagecopyresampled($im2,$im,0,0,0,0,$targetHeight,$targetWidth,$dimensions[0],$dimensions[1]);
					//make sure we were able to create this image
					if ($im2 !== FALSE) {
						imagejpeg($im2, $newDir.end($filename));
						imagedestroy($im2);
					}
					imagedestroy($im);
				}
			}
		}
	}
}

function watermarkImage($baseDir, $newDir, $targetX, $targetY){
	
	//lets get our images
	$images = glob($baseDir.'*.{jpg,png,gif}', GLOB_BRACE);
	//make sure we have our images before we loop through them
	$watermark = "./watermark.png";
	
	if($images !== false && is_array($images) && count($images) > 0){
		foreach($images as $image) {
			
			set_time_limit(15);
			
			$dimensions = getimagesize($image);
			$dimensionsWM = getimagesize($watermark);
			$filesize = filesize($image);
			$filename = explode("/",$image);
			
			$xpos = ($dimensions[0] - $dimensionsWM[0] - $targetX);
			$ypos = ($dimensions[1] - $dimensionsWM[1] - $targetY);
			
			if(class_exists('Imagick')) { //check if imagick exists on here
				$im = new Imagick($image);
				
				// Open the watermark
				$wm = new Imagick($watermark);
				$wm->setBackgroundColor(new ImagickPixel('transparent'));
				//$wm->setImageOpacity(0.5);
				$wm->evaluateImage(Imagick::EVALUATE_MULTIPLY, 0.5, Imagick::CHANNEL_ALPHA);
				
				// Overlay the watermark on the original image
				$im->compositeImage($wm, imagick::COMPOSITE_OVER, $xpos, $ypos);
				
				$im->writeImage($newDir.end($filename));
				
				$im->clear();
				$wm->clear();
			}
			else{ //repeat using the GD library
				$im = imagecreatefromjpeg($image); //this function will change based on image types
				$im2 = imagecreatefrompng($watermark);
				
				// Merge the stamp onto our photo with an opacity of 50%
				imagecopymerge($im, $im2, $xpos, $ypos, 0, 0, $dimensionsWM[0], $dimensionsWM[1], 50);
				
				//save the new image
				imagejpeg($im, $newDir.end($filename));
				
				//clear up the memory
				imagedestroy($im);
				imagedestroy($im2);
			}
		}
	}
}

function pieChartBuilder($location, $data, $width, $height){
	
	// create image
	$image = imagecreatetruecolor($width, $height);
	
	$bgcolor = imagecolorallocate($image, 55, 55, 55);
	imagefill($image, 0, 0, $bgcolor);
	
	$margin = 10; //space from the edges
	$thickness = 20; //thickness of the piechart
	$downFromCenter = 35; //offset for the vertical position
	
	//make a new data set to hold additional information
	foreach($data as $ind => $val){
		$pieData[$ind]['val'] = $val;
		$pieData[$ind]['red'] = rand(20,200);
		$pieData[$ind]['green'] = rand(20,200);
		$pieData[$ind]['blue'] = rand(20,200);
		$pieData[$ind]['pct'] = (($val/array_sum($data))*100);
		$pieData[$ind]['deg'] = (($val/array_sum($data))*360);
	}

	// make the 3D effect
	for($i = ((($height/2)+$downFromCenter)+$thickness); $i > ($height/2)+$downFromCenter; $i -= 1) {
		$startPos = 0; //this tracks our starting degrees for each segment of the chart
		foreach($pieData as $ind2 => $pieVal){
			imagefilledarc($image, intval($width/2), $i, intval($width-($margin*2)), intval(($height/2)-($margin*2)), $startPos, ($startPos+$pieVal['deg']), imagecolorallocate($image, $pieVal['red'], $pieVal['green'], $pieVal['blue']), IMG_ARC_PIE);
			$startPos += $pieVal['deg']; //update our starting position to the end of this position so our pieces don't overlap
		}
	}
	
	$startPos = 0; //this tracks our starting degrees for each segment of the chart
	foreach($pieData as $ind2 => $pieVal){
		imagefilledarc($image, intval($width/2), intval($height/2)+$downFromCenter, intval($width-($margin*2)), intval(($height/2)-($margin*2)), $startPos, ($startPos+$pieVal['deg']), imagecolorallocate($image, ($pieVal['red']+30), ($pieVal['green']+30), ($pieVal['blue']+30)), IMG_ARC_PIE);
		$startPos += $pieVal['deg']; //update our starting position to the end of this position so our pieces don't overlap	
	}
	
	//now we can make our legend
	$font = "./ConcertOne-Regular.ttf";
	$counter = 1;
	foreach($pieData as $ind => $val){
		//get some of our starting values
		$cols = 3;
		$colNum = (($counter-1)%$cols);
		$rowNum = ceil($counter/$cols); //this will round up to the nearest whole number, giving us an accurate row number for positioning
		$lineSpacing = 15;
		$linePadding = 5;
		$rowHeight = $lineSpacing+$linePadding;
		
		$color = imagecolorallocate($image, ($val['red']+30), ($val['green']+30), ($val['blue']+30));
		
		$x1 = ((($width-($margin*2))/$cols)*$colNum)+$margin;
		$y1 = ($rowHeight*$rowNum)+$margin;
		$x2 = $x1+$lineSpacing;
		$y2 = $y1+$lineSpacing;
		
		//now we consider the spacing
		imagefilledrectangle($image, $x1, $y1, $x2, $y2, $color); // Draw a white rectangle
		imagettftext($image, $lineSpacing, 0, ($x2+15), $y2, $color, $font, $ind." (".number_format($val['pct'],2)."%)");
		
		$counter += 1;
	}
	
	imagepng($image, $location);
	imagedestroy($image);
	
}

?>
