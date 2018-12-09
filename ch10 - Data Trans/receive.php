<?php

/*
Chapter 10 - Data Processing
Goal: Demonstrate the use of variables, loops and functions in a working application
Scenario: Process randomly generated purchase orders to generate invoice slips.

Background:
- The orders CSV is structured as such: ID | Status | Item Name | Price | Purchase Date | Processed Date | Buyer
- This writes to a new datestamped CSV instead of overwriting the existing CSV for reuseability.
*/

//print_r($_POST);
//print_r($_FILES);

//begin capturing our values
$yourName = getVar("yourName");
$yourEmail = getVar("yourEmail");
$interest = getVar("interest");
$satisfaction = getVar("satisfaction");
$adventures = getVar("adventures");
$hiddenType = getVar("hiddenType");
$photo = getPhoto("ugc/","myPhoto");

//perform our validation
if(empty($yourName) || empty($yourEmail)){
	echo "Please go back and make sure that your name and email are filled in.";
	exit();
}

//construct our message
$message = "Hello,
$yourName has contacted you about camping. They love it!
Their favorites include:\n";
foreach($adventures as $adventure){
	$message .= " - $adventure \n";
}
$message .= "Take a look of this <a href='localhost/code/ch7/ugc/$photo'>photo!</a>";

//send out email
$from = 'name@server.com';
$subject = "Hello from PHP";

//lets just make this a given..
$htmlenabled = 'yes';

if($htmlenabled == 'yes'){
	$headers = "From: ". $yourName ." <". $from .">\n";
	$headers .= "Reply-To: noreply <". $from .">\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$send = mail($yourEmail, stripslashes($subject), stripslashes($message), $headers, '-f'.$from);
}
else{
	$send = mail($yourEmail, $subject, $message, null, '-f'.$from);
}


function getVar($varName, $defVal = ""){
	if(!isset($_POST[$varName])){
		$tempVar = $defVal;
	}
	else{
		if(!is_array($_POST[$varName])){
			$tempVar = trim(htmlspecialchars($_POST[$varName], ENT_QUOTES));
		}
		else{
			$tempVar = $_POST[$varName];
		}
	}
	return $tempVar;
}

function getPhoto($location, $imgfield){
		
	//check for uploaded files
	if(!empty($_FILES[$imgfield])){
		$file_array = $_FILES[$imgfield]; //shortening for ease of use
			
		//confirm they are an image
		$splitName = explode(".",$file_array['name']);
		$type = strtolower($splitName[(count($splitName)-1)]);
		
		if($type == "jpg" || $type == "jpeg" || $type == "gif" || $type == "png"){
			if(is_uploaded_file($file_array['tmp_name'])){
				//get the file name and type
				$fileName = date('Y-m-d-His',strtotime("now")).".".$type; //strtolower($file_array['name']);
				
				//put it in the directory
				move_uploaded_file($file_array['tmp_name'],$location."$fileName") or die();
				
			} // end of if
		} // end of file type check
		return $fileName;
	} // end of if
}


?>
