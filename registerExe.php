<?php

$rollno=$_POST['roll_no'];
$name=$_POST['name'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$email=$_POST['email'];
$division=$_POST['division'];
$batch=$_POST['batch'];
$year = date("Y");
$con=mysqli_connect("localhost","root","","dmine") or die ('I cannot connect to the database because: ' . mysql_error());
$mkDbCon=mysqli_connect("localhost","root","") or die ('I cannot connect to the database because: ' . mysql_error());
$response = array();

$query = "INSERT INTO students(roll_no,password,name,email,division,batch,year) VALUES ('$rollno','$password','$name','$email','$division','$batch','$year')";
  if($password==$cpassword)
  {
    if(mysqli_query($con,$query))
        {
      $sql = "CREATE DATABASE $rollno";
      if ($mkDbCon->query($sql) === TRUE) {
        $response['registration_success'] = true;
      } else {
        $response['registraion_success'] = false;
        $response['registration_error'] = "Error creating database: " . $mkDbCon->error;
      }
        }
        else
        {
          $response['registration_success'] = false;
      $response['registration_error'] = "Error: ".$mkDbCon->error;
        }

  }else{
    $response['registraion_success'] = false;
    $response['registration_error'] = "Passwords did not match";
  }
  echo json_encode($response);
  ?>
