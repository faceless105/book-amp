<?php

/*
Chapter 11 - User Authentication
Goal: Demonstrate a working user authentication system

*/

include('settings.php');
include('functions.php');
include('login.php');

//check and process any potential logins before we generate any output
loginProcessor();

$loggedIn = loginCheck();
	
if($loggedIn === false){ //can't be verified if you aren't even logged in
	
	echo '<div class="loginBox">
	<form action="index.php" enctype="multipart/form-data" method="post">
		<table class="registration">
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
					<td colspan="2"><input type="submit" name="submit" value="Login"></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>';
	
}
else{
	echo "Congratulations, you have successfully logged into this site.";
}





?>
