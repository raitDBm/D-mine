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
<?php
$con=mysqli_connect("localhost","root","","dmine") or die ('I cannot connect to the database because: ' . mysql_error());
require 'PHPMailer/PHPMailerAutoload.php';

$otp=(rand(1000000000,99999999999));

$roll_no = $_POST['roll_no'];
$query="SELECT * from students where roll_no='$roll_no'";
$result = mysqli_query($con,$query);


if($result)
{
	$row=mysqli_fetch_array($result,MYSQLI_NUM);
	$name = $row[2];
	$email = $row[3];
	date_default_timezone_set('Asia/Kolkata');
	$mail = new PHPMailer;
	$mail->isSMTP();
	//$mail->SMTPDebug = 3;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "raitdbsystem@gmail.com";
	$mail->Password = "rait@123";
	$mail->setFrom('raitdbsystem@gmail.com', 'Database App');
	$mail->addAddress($email);
	$mail->Subject = 'OTP for Database system login';
	$mail->Body = 'Enter this otp to change password '.$otp;
	$mail->AltBody = 'otp:'.$otp;
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "<br>otp sent!Check You email id:".$email;
		echo "<script>setTimeout(function () {window.location.href = 'enterotp.php'; },4000);</script>";
		$_SESSION['otp']=$otp;
		$_SESSION['roll_no']=$roll_no;
	}

}
else {
	echo "query did not run".$con->error;
}
?>
</div>
</body>
</html>