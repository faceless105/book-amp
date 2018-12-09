<!DOCTYPE html>
<html lang="en-US">
<head><title>Chapter 10 - Data Transmissions</title>
<link rel="stylesheet" href="ch`0.css">
</head>
<body>

<div class="formContainer">
<div class="formName">Contact Us</div>
<form action="receive.php" enctype="multipart/form-data" method="post">
	
	<div class="field">
		<div class="label">Your Name</div>
		<div class="options"><input type="text" name="yourName" value=""></div>
	</div>
	
	<div class="field">
		<div class="label">Your Email</div>
		<div class="options"><input type="text" name="yourEmail" value=""></div>
	</div>
	
	<div class="field">
		<div class="label">What are you interested in<br>(select all that apply)</div>
		<div class="options">
			<select name="interest[]" multiple>
				<option value="tents">Tents</option>
				<option value="bags">Sleeping Bags</option>
				<option value="stoves">Camp Stoves</option>
				<option value="packs">Backpacks</option>
			</select>
		</div>
	</div>
	
	<div class="field">
		<div class="label">Are you happy with the site?</div>
		<div class="options">
			<label><input type="radio" name="satisfaction" value="yes" checked> Yes</label><br>
			<label><input type="radio" name="satisfaction" value="no"> No</label><br>
			<label><input type="radio" name="satisfaction" value="notsure"> Not Sure</label>
		</div>
	</div>
	
	<div class="field">
		<div class="label">Your Adventures Include</div>
		<div class="options">
			<label><input type="checkbox" name="adventures[]" value="hiking"> I love hiking</label><br>
			<label><input type="checkbox" name="adventures[]" value="boating"> I love boating</label>
		</div>
	</div>

	<div class="field">
		<div class="label">Send us an image from your favorite camping trip!</div>
		<div class="options"><input type="file" name="myPhoto"></div>
	</div>
	
	<div class="formButtons">
		<input type="hidden" name="hiddenType" value="hiddenVal">
		<input type="submit" value="Contact Us">
	</div>
</form>
</div>

</body>
</html>
