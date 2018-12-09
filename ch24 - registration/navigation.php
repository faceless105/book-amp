<?php

function thePortal($theCase){

	$loginCheck = loginCheck();
	
	switch($theCase){
		
		case 'registration': //users.php
			return showRegistration();
			break;
		
		case 'processRegistration': //users.php
			return processRegistration();
			break;
		
		case 'activate': //users.php
			return activate();
			break;
			
		default:
			if($loginCheck === false){
				return showLogin();
			}
			else{
				return showWelcome();
			}
			break;
		
	} // end of the switch
}

?>
