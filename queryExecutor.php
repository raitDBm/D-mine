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

case "TruncateTable":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
	{
		if($conn->query($query_Stat)=== TRUE){
			echo "Table truncated succesfully";
		}
		else{
			echo "error truncating database"; 
		}
	}
	else {
		echo "Database does not exist";
	}
	break;
	
case "desc":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	if($conn->select_db($DB_Name))
	{
		$result=mysqli_query($conn,$query_Stat);
		/*echo "<br><b>".$tablename." structure</b><br><br>";*/
		echo "
		<tr>
		<td align=center> <b>FIELD</b></td>
		<td align=center><b>TYPE</b></td>
		<td align=center><b>NULL</b></td>
		<td align=center><b>KEY</b></td></td>
		<td align=center><b>DEFAULT</b></td>
		<td align=center><b>EXTRA</b></td>";

		while($data = mysqli_fetch_row($result))
		{   
			echo "<tr>";
			echo "<td align=center>$data[0]</td>";
			echo "<td align=center>$data[1]</td>";
			echo "<td align=center>$data[2]</td>";
			echo "<td align=center>$data[3]</td>";
			echo "<td align=center>$data[4]</td>";
			echo "<td align=center>$data[5]</td>";
			echo "</tr>";
		}
		
	}
	else {
		echo "Database does not exist";
	}
case "addColumn":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
	{
		if($conn->query($query_Stat)=== TRUE){
			echo "columns addded succesfully";
		}
		else{
			echo "error occured while adding tables. Try again.."; 
		}
	}
	else {
		echo "Database does not exist";
	}
	break;
default:
    echo "Nothing to show";
}

?>
