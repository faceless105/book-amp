<?php
/* 
This is a place to maintain general use functions that you might reuse frequently from project to project

getVar($varName, [$method], [$defVal]): This will check a variable on a particular method and return the value
Params:
-  $varName - This is the name of the variable we are looking up
-  $method (optional) - This is the method, $_GET, $_POST, $_SESSION, $_COOKIE. If none is provided, it will try get and post. If a POST value is present, it will override a GET variable because POST is more secure.
-  $defVal (optional) - This is the default value to be returned if no variable is found on the provided method.
Returns the found value or the provided default value.
*/

function getVar($varName, $method = "", $defVal = ""){
	
	$tempVar = "";
	
	if($method == ""){
		if (isset($_POST[$varName]) || isset($_GET[$varName])) {
			if (isset($_GET[$varName])) {
				if(!is_array($_GET[$varName])){
					$tempVar = trim(htmlspecialchars($_GET[$varName], ENT_QUOTES, "UTF-8"),"");
				}
				else{
					$tempVar = $_GET[$varName];
				}
			}
			if (isset($_POST[$varName])) {
				if(!is_array($_POST[$varName])){
					$tempVar = trim(htmlspecialchars($_POST[$varName], ENT_QUOTES, "UTF-8"),"");
				}
				else{
					$tempVar = $_POST[$varName];
				}
			}
		}
		else {
			$tempVar = $defVal;
		}
		return $tempVar;
	}
	
	elseif($method == "get"){
		if(!isset($_GET[$varName])){
			$tempVar = $defVal;
		}
		else{
			if(!is_array($_GET[$varName])){
				$tempVar = trim(htmlspecialchars($_GET[$varName], ENT_QUOTES, "UTF-8"),"");
			}
			else{
				$tempVar = $_GET[$varName];
			}
		}
		return $tempVar;
	}
	
	elseif($method == "post"){
		if(!isset($_POST[$varName])){
			$tempVar = $defVal;
		}
		else{
			if(!is_array($_POST[$varName])){
				$tempVar = trim(htmlspecialchars($_POST[$varName], ENT_QUOTES, "UTF-8"),"");
			}
			else{
				$tempVar = $_POST[$varName];
			}
		}
		return $tempVar;
	}
	
	elseif($method == "session"){
		if(!isset($_SESSION[$varName])){
			$tempVar = $defVal;
		}
		else{
			if(!is_array($_SESSION[$varName])){
				$tempVar = trim(htmlspecialchars($_SESSION[$varName], ENT_QUOTES, "UTF-8"),"");
			}
			else{
				$tempVar = $_SESSION[$varName];
			}
		}
		return $tempVar;
	}
	
	elseif($method == "cookie"){
		if(!isset($_COOKIE[$varName])){
			$tempVar = $defVal;
		}
		else{
			if(!is_array($_COOKIE[$varName])){
				$tempVar = trim(htmlspecialchars($_COOKIE[$varName], ENT_QUOTES, "UTF-8"),"");
			}
			else{
				$tempVar = $_COOKIE[$varName];
			}
		}
		return $tempVar;
	}
}

function reportDirectory($dir, $dirLabel){
	
	$retString = "<div class='dirLabel'>".$dirLabel."</div>";
	
	//lets get our images
	$images = glob($dir.'*.{jpg,png,gif}', GLOB_BRACE);
	//make sure we have our images before we loop through them
	$retString .= "<div class='dirList'>";
	if($images !== false && is_array($images) && count($images) > 0){
		$retString .="<table class='directory'>";
		$retString .="<tr><th>File Name</th><th>File Size</th><th>Image Width</th><th>Image Height</th><th>Aspect Ratio</th><th>Aspect Ratio PCT</th></tr>";
		foreach($images as $image) {
			$dimensions = getimagesize($image);
			$filesize = filesize($image);
			$filename = explode("/",$image);
			$retString .="<tr><td><a href='".$image."' target='_blank'>". end($filename) ."</a></td><td>".fileSizeConvert($filesize)."</td><td>".$dimensions[0]."</td><td>".$dimensions[1]."</td><td>". getImgAspect($dimensions[0],$dimensions[1]) ."</td><td>". number_format(($dimensions[0]/$dimensions[1]),2) ."</td></tr>";
		}
		$retString .="</table>";
	}
	$retString .= "</div>";
	return $retString;
}

function fileSizeConvert($bytes){

    $bytes = floatval($bytes);
    $arBytes = array("TB" => pow(1024, 4), "GB" => pow(1024, 3), "MB" => pow(1024, 2), "KB" => 1024, "B" => 1);

    foreach($arBytes as $unit => $val){
        if($bytes >= $val){
            $result = $bytes / $val;
            $result = strval(round($result, 2))." ".$unit;
            break;
        }
    }
    return $result;
}

function getImgAspect($width, $height) {
	//get our pct
	$commondenom = $gcd = gcd($width,$height);
	$widthLowest = $width/$commondenom;
	$heightLowest = $height/$commondenom;
	return $widthLowest.":".$heightLowest;
}

function gcd($v1,$v2) {
    return ($v1%$v2) ? gcd($v2,$v1%$v2) : $v2;
}

?>
