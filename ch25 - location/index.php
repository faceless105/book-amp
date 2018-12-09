<?php

/*
Chapter 25 - Whats nearby
Goal: 

*/

include('defaults.php');

?>

<html>
<head></head>
<body>

<div id="statusBox">Preparing our Tools....</div>

<script>

statusBox = document.getElementById("statusBox");

function getLocation() {
	
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPos);
	}
	else { 
		statusBox.innerHTML = "Preparing our Tools....<br> - Geolocation is not supported by this browser.";
	}
}

function showPos(position){
	statusBox.innerHTML = "Preparing our Tools....<br> - Latitude: "+ position.coords.latitude +"<br> - Longitude: "+ position.coords.longitude +"<br> - <a href='index.php?lat="+ position.coords.latitude +"&lon="+ position.coords.longitude +"'>Send these coordinates to this page.</a>";
}

getLocation();

</script>
<div class="output">
<?php locationTools(); ?>
</div>
</body>
</html>
