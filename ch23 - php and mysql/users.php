<?php

function showRegistration(){
	
	$email = getVar("email");
	$password = getVar("password");
	
	//show the registration form
	$output = '<div class="loginBox">
	<form action="index.php" enctype="multipart/form-data" method="post">
		<table class="registration">
			<thead><tr><th colspan="2">User Registration</th></th></thead>
			<tbody>
				<tr>
					<td>Email</td>
					<td><input type="email" name="userEmail" value="'. $email .'" required></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="userPass" value="'. $password .'" required></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="theCase" value="processRegistration">
						<input type="submit" name="submit" value="Register">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>';

	return $output;
	
}

function processRegistration(){
	
	$email = getVar("userEmail");
	$password = getVar("userPass");
	
	//first we look for a valid login
	if(!empty($email) && !empty($password)){
		//make our new user. send out a confirmation email
		$newUser = registerUser($email, $password);
		if($newUser !== false){ //registration was successful, lets
			return "Thank you for registering for the site. please check your email shortly for an activation link.";
		}
		else{
			return "There was a problem registering you for our site.";
		}
	}
	if(!empty($email) && !empty($email2) && $email != $email2){
		return 'Please make sure that your emails match.';
	}
	elseif(!empty($password) && !empty($password2) && $password != $password2){
		return 'Please make sure that your passwords match.';
	}
	
}

function registerUser($email, $password){
	
	global $conn;
	
	$activatedCode = makeActCode(25);
	
	$sql = $conn->prepare("INSERT INTO users(`userEmail`, `userPass`, `activated`, `actCode`, `joinDate`) VALUES(?, MD5(?), 0, ?, NOW())");
	$res = $sql->execute([$email, $password, $activatedCode]);
	$userID = $conn->lastInsertId();
	
	if($res){
		
		$message = '<div>
	Hello,
We look forward to seeing you around. To confirm your account, please follow this link: '. BASE_URL .'activate?code='. $activatedCode .'&userID='. $userID .'
</div>';
		$from = 'name@server.com';
		$yourName = 'Registration Bot';
		$subject = 'Account Activation';
		
		//lets just make this a given..
		$htmlEnabled = 'yes';
		
		if($htmlEnabled == 'yes'){
			$headers = "From: ". $yourName ." <". $from .">\n";
			$headers .= "Reply-To: noreply <". $from .">\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			$sending = mail($email, stripslashes($subject), stripslashes($message), $headers, '-f'.$from);
		}
		else{
			$sending = mail($email, $subject, $message, null, '-f'.$from);
		}
		
		return true;
	}
	else{
		return false;
	}
	
}

function activate(){
	
	global $conn;
	
	$code = getVar("code");
	$userID = getVar("userID");
	
	//Now we can see if we have a match
	$sql = $conn->prepare("SELECT id FROM users WHERE id = ? AND actCode = ?");
	$res = $sql->execute([$userID, $code]);
	
	$user = $sql->fetch();
	
	if(is_array($user) && count($user) > 0){
		$sql = $conn->prepare("UPDATE users SET activated = 1 WHERE id = ? AND actCode = ?");
		$res = $sql->execute([$userID]);
		$output = "Thank you for activating your account. You may now sign in.";
	}
	else{
		$output = "Sorry, this activation link is not valid";
	}
	
	return $output;
	
}

//this function will see if a user is logged in and activated. Then it will welcome them to the site.
function showWelcome(){
	
	//get the user
	$user = getUser();
	if($user !== false && is_array($user) && count($user) > 0){
		$output = 'Hello '. $user['userEmail'] .'<br>';
		$output .= 'Your account has '. ($user['activated'] == false ? 'not ' : '') .'been activated.<br>';
		$output .= 'Your last activity was: '. $user['lastActivity'];
		return $output;
	}
	else{
		return "Welcome to the site. Your account could not be retreived at this time.";
	}
	
}

function getUser(){
	
	global $conn;
	
	if(!isset($_SESSION['userInfo'])){
		return false;
	}
	// now we check for the login...
	else{
		
		//get the userAgent
		$ua = $_SERVER['HTTP_USER_AGENT'];
		
		$sql = $conn->prepare("SELECT * FROM users INNER JOIN sessions ON users.id = sessions.userid WHERE users.id = :uid AND sessions.userAgent = :ua LIMIT 1");
		$res = $sql->execute(['uid'=>$_SESSION['userInfo']['userID'], 'ua'=>$ua]);
	
		$user = $sql->fetch();
	
		if(is_array($user) && count($user) > 0){
			return $user;
		}
		else{
			return false;
		}
	}
	
}




?>
