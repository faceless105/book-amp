<?php
/*
This is where login specific functions will exist

loginProcessor(): Checks for an new or active login session.

*/

function loginProcessor(){
	
	//post checks
	$userEmail = getVar('userEmail','post');
	$userPass = getVar('userPass','post');
	
	//cookies
	$userID = getVar('userID','cookie');
	$userSession = getVar('session','cookie');
	
	//active logout
    $logout = getVar('logout','get');
	
	//check that they aren't logging out first
	if($logout == "logout"){
		setcookie('userID', "", time()-1209600, SITE_PATH, SHORT_URL, false, true); // expire the cookie
		setcookie('session', "", time()-1209600, SITE_PATH, SHORT_URL, false, true); // expire the cookie
		unset($_SESSION['userInfo']);
		header("Location: ".BASE_URL, true);
		return;
	}
	
	//now we check if they're already logged in.. check for an active cookie
	if($userSession != ''){ //already logged in, this is a page load
		//lets see if this potential user is valid
		//This can be replaced with any method of validation. Validating against a database, checking against Facebook or Twitter through an API, or even just checking against a text file on the server.
		if($userID == 1 && $userSession == 12345){ //we have a valid user and session
			//now we can update the cookies so they don't expire
			setcookie('userID', $userID, time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks
			setcookie('session', $userSession, time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks
			makeUserSession($userID, $userSession);
			return;
		}
		else{ //if these did not match, the cookie may have been tampered with...
			setcookie('userID', "", time()-1209600, SITE_PATH, SHORT_URL, false, true); // expire the cookie
			setcookie('session', "", time()-1209600, SITE_PATH, SHORT_URL, false, true); // expire the cookie
			unset($_SESSION['userInfo']);
			return;
		}
	}
	//check initial login
	elseif ($userEmail != "" && $userPass != ""){
		//this is a login attempt and we must validate it
		//Just like above, this can be replaced with any method of validation. Validating against a database, checking against Facebook or Twitter through an API, or even just checking against a text file on the server.
		if($userEmail == "name@server.com" || $userPass == "thisisabadpass"){ //we have a registered user
			setcookie('userID', $userID, time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks time
			setcookie('session', 12345, time()+1209600, SITE_PATH, SHORT_URL, false, true);
			makeUserSession($userID, 12345);
		}
		else{
			//this user could not be found
			return 'There was a problem logging you in. Please go back and try again.';
		}
		return;
	}
	return;
}


/****************************
** Function, loginCheck
** First, this just checks if a user is logged in
*****************************/
function loginCheck(){
	
	//active logout
    $logout = getVar('logout','get');
	
	//check that the information was provided
	if($logout == "logout"){
		return false;
	}
	//this is a page load that is not logged in
	elseif(!isset($_SESSION['userInfo'])){
		return false;
	}
	// now we check for the login...
	elseif(isset($_SESSION['userInfo'])){
		return true;
	}// end of elseif
}


function makeUserSession($id){
	
	$userArray = array(
		'userID' => $id, 
		'displayName' => 'John Sly');
	
	//populate the session
	$_SESSION['userInfo'] = $userArray;
	
}




?>
