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

function makeActCode($len) {
	
	$chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	$charsLen = (strlen($chars) - 1);
	$rand = '';
	
	for ($i = 0; $i < $len; $i += 1) {
		$rand .= $chars[rand(0, $charsLen)];
	}
	
	return $rand;
}

?>
