<?php
/*
This is where login specific functions will exist

loginProcessor(): Checks for an new or active login session.

*/

function loginProcessor(){
	
	global $conn;
	
	//post checks
	$userEmail = getVar('userEmail','post');
	$userPass = getVar('userPass','post');
	
	//cookies
	$userID = getVar('userID','cookie');
	$userSession = getVar('session','cookie');
	
	//get the userAgent
	$ua = $_SERVER['HTTP_USER_AGENT'];
	
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
	if(!empty($userSession)){ //already logged in, this is a page load
		//lets see if this potential user is valid
		//This can be replaced with any method of validation. Validating against a database, checking against Facebook or Twitter through an API, or even just checking against a text file on the server.
		$sql = $conn->prepare("SELECT * FROM `sessions` WHERE `userid` = :userid AND `userAgent` = :ua AND `token` = :token LIMIT 1");
		$sql->execute(['userid'=>$userID, 'ua'=>$ua, 'token'=>$userSession]);
		$res = $sql->fetch();
		if($userID == $res['userid'] && $userSession == $res['token']){ //we have a valid user and session
			//now we create a new token to help lock down the site
			$userSession = makeActCode(25); //having a rotating token will help prevent potential brute force crackers
			//now we can mark the latest activity
			$sql = $conn->prepare("UPDATE sessions SET `lastActivity` = NOW(), `token` = :token WHERE `id` = :resid");
			$sql->execute(['token'=>$userSession, 'resid'=>intval($res['id'])]);
			//now we can update the cookies so they don't expire
			setcookie('userID', $userID, time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks
			setcookie('session', $userSession, time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks
			makeUserSession($userID);
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
	elseif (!empty($userEmail) && !empty($userPass)){
		//this is a login attempt and we must validate it
		$sql = $conn->prepare("SELECT * FROM `users` WHERE `userEmail` = :email AND `userPass` = MD5(:pass) LIMIT 1");
		$sql->execute(['email'=>$userEmail, 'pass'=>$userPass]);
		$user = $sql->fetch();
		//Just like above, this can be replaced with any method of validation. Validating against a database, checking against Facebook or Twitter through an API, or even just checking against a text file on the server.
		if($user !== false){ //we have a registered user
			//create a new session Variable
			$userSession = makeActCode(25);
			
			$sql = $conn->prepare("REPLACE INTO sessions (`userid`, `userAgent`, `token`, `lastActivity`, `created`) VALUES (?, ?, ?, NOW(), NOW())");
			$res = $sql->execute([$user['id'], $ua, $userSession]);
			
			$c1 = setcookie('userID', $user['id'], time()+1209600, SITE_PATH, SHORT_URL, false, true); // 2 weeks time
			$c2 = setcookie('session', $userSession, time()+1209600, SITE_PATH, SHORT_URL, false, true);
			//echo "And here we have $c1 -- $c1<br><br>\n\n";
			makeUserSession($user['id']);
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
	if(!isset($_SESSION['userInfo'])){
		return false;
	}
	// now we check for the login...
	else{
		return true;
	}// end of elseif
}


function makeUserSession($id){
	
	$userArray = array(
		'userID' => $id
	);
	
	//populate the session
	$_SESSION['userInfo'] = $userArray;
	
}

function showLogin(){
	
	$output = '<div class="loginBox">
	<form action="index.php" enctype="multipart/form-data" method="post">
		<table class="login">
			<thead><tr><th colspan="2">User Login</th></th></thead>
			<tbody>
				<tr>
					<td>Email</td>
					<td><input type="email" name="userEmail" value="" required></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="userPass" value="" required></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Login"></td>
					<td><a href="'. BASE_URL .'register">Register</a></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>';
	
	
	return $output;
	
}



?>
