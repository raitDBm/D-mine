<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-colors-signal.css">
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-colors-food.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<header class="w3-container w3-center">
  <h1> <img src="images/logo.png" ></h1>
</header>
<br>


<div class="w3-container w3-card-4 w3-round-large w3-border" style="max-width:500px;margin:0 auto;padding:10px;">
<div class="w3-card-2 w3-padding" style = "background-color: #ffffcc;border-left: 6px solid #ffeb3b;"><b><u>NOTE:</u></b>DO NOT close the browser. otp will be destroyed if you close the browser.</div>
<form class="w3-form w3-margin-top"action="updatepass.php" method="post" autocomplete="off">
	

		
		<label>OTP</label><br>
		<input type="text" name="otp" style="margin-bottom:10px;" class="w3-input" required /><br>
		
		
		<label>NEW PASSWORD <label><br>
		<input type="password" name='pass1' maxlength='100' style="margin-bottom:10px;" class="w3-input" required/><br>
		
		
		<label>CONFIRM PASSWORD </label><br>
		<input type="password" name='pass2' maxlength='100' style="margin-bottom:10px;" class="w3-input" required><br>
		
		<input class="w3-btn w3-signal-red w3-round-xlarge" style="width:100%; margin-bottom:15px;" type="submit" value="SUBMIT" />
		
	</table>
</form>
</div>
</body>

</html>