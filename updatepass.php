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
<div class="w3-container">
<div class="w3-container w3-card-4 w3-round-large w3-border" style="max-width:600px;margin:0 auto;padding:10px;margin-top:15px">
<?php
$con=mysqli_connect("localhost","root","","dmine") or die ('I cannot connect to the database because: ' . mysql_error());
$roll_no=$_SESSION['roll_no'];
$otps=$_SESSION['otp'];
$otpf=$_POST['otp'];
$pass1=$_POST['pass1'];
$pass2=$_POST['pass2'];

if($otps==$otpf)
{
if($pass1==$pass2)
{

	$changepass="UPDATE students SET password='$pass1' WHERE roll_no = '$roll_no'";
	mysqli_query($con,$changepass);
	echo 'password changed succesfully. Login <a href="login.html">here</a>';
	unset($_SESSION['otp']);
	unset($_SESSION['roll_no']);
}
else
{
	echo 'passwords did not match.Please try again <a href="enterotp.php">click here</a>';
}
}
else{
	echo "otp did not match.Please try again <a href='enterotp.php'>click here</a>";
}
?>
</div>
</div>
</body>
</html>