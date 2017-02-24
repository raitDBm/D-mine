<?php
//server connection script
include 'dbconnect.php';

//tag which is fetch from sender
$tags=$_POST['tag'];

//main logic
switch ($tags)
{
case "createDatabase":

    $DBName=$_POST['dbName'];
    $sql = "CREATE DATABASE $DBName";
    if ($conn->query($sql) === TRUE) {
      echo "Database created successfully";
    } else {
      echo "Error creating database: " . $conn->error;
    }
    $conn->close();
    break;

case "selectDB":
    $DBName=$_POST['dbName'];
    if($conn->select_db($DBName))
    {
      echo "Database selected successfully..!";
    }
    else {
      echo "Database is not selected..!";
    }
    break;

case "createTable":
    $DB_Name=$_POST['db_Name'];
    $query_Stat=$_POST['Query'];
    if($conn->select_db($DB_Name))
    {
      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Table created successfully";
      } else {
          echo "Error creating table: " . $conn->error;
      }
    }
    else {
      echo "Database is not selected..!";
    }
    break;

case "DropTable":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
    {
      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Table dropped successfully";
      } else {
          echo "Error dropping table: " . $conn->error;
      }
    }
    else {
      echo "Database is not selected..!";
    }
    break;
	
	
case "DropDatabase":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
    {
      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Database dropped successfully";
      } else {
          echo "Error dropping Database: " . $conn->error;
      }
    }
    else {
      echo "Database does not exist..!";
    }
    break;
default:
    echo "Nothing to show";
}

?>
