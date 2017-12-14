<?php
$roll_no=$_POST['roll_no'];
$password=$_POST['password'];
$con=mysqli_connect("localhost","root","","dmine") or die ('I cannot connect to the database because: ' . mysql_error());

$query = "select * from students where roll_no='$roll_no'  and password='$password' ";

$query_run = mysqli_query($con,$query);
$response = array();
if($query_run)
{
  if(mysqli_num_rows($query_run)>0)
  {
    session_start();
    $_SESSION['roll_no'] = $roll_no;
    $DBName = $_SESSION['roll_no'];
    $response['login_status'] = true;

    echo json_encode($response);
  }
  else
  {
    $response['login_status'] = false;

    echo json_encode($response);
  }
}
?>
