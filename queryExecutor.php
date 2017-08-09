<?php
//server connection script
include 'dbconnect.php';

//tag which is fetch from sender
$tags=$_POST['tag'];

//main logic
switch ($tags)
{
case "addcol":
//echo "you r trying to add column!!";
$DBName=$_POST['db'];
$tb=$_POST['tb'];
$cn=$_POST['cn'];
$dt=$_POST['dt'];
$size=$_POST['size'];
if($cn!='' && $dt!='' && $size!='')
{
  $sql="ALTER TABLE $tb ADD $cn $dt($size);";
  if($conn->select_db($DBName)){
  if($conn->query($sql) === TRUE)
  {
    echo "column added successfully,refresh to see result...";
  }
  else
    echo "Error: " . $conn->error;
}
}
else
echo "Enter value...";
break;

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

case "SelectExecution":
  $Sel_Cmd=$_POST['SelCmd'];
  $DB_Name="dsd";
  if($conn->select_db($DB_Name))
	{
    if ($result = $conn->query($Sel_Cmd)) {


        while ($finfo = $result->fetch_field())
        {
          printf("%s\n", $finfo->name);
          while ($row = $result->fetch_assoc())
          {
                 printf ("%s\n", $row["$finfo->name"]);
          }
        }
        $result->close();
    }
    $conn->close();
  }
  break;

  case "DbDropdownList":
        $list = array();
        $query = "SHOW DATABASES";
        $result = $conn->query($query);
        $rowCount = $result->num_rows;

        /* fetch associative array */
        for($i=0; $i<$rowCount; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQL_NUM);
            $list[$i] = $row[0];

        }
        echo json_encode($list);
        /* free result set */
        $result->free();
        break;

    case "TbDropdownList":
        $DB_Name=$_POST['dbName'];
        $list = array();
        if($conn->select_db($DB_Name))
        {
            $query = "show tables from $DB_Name";
            $result = $conn->query($query);
            $rowCount = $result->num_rows;
            for($i=0; $i<$rowCount; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQL_NUM);
                $list[$i] = $row[0];

            }
            echo json_encode($list);

        }
        else {
            echo "Database is not selected..!";
        }

        /* free result set */
        $result->free();
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
		<td align=center><b>EXTRA</b></td>
		<td align=center></td>";

            while($data = mysqli_fetch_row($result))
            {
                echo "<tr id='$data[0]'>";
                echo "<td align=center>$data[0]</td>";
                echo "<td align=center>$data[1]</td>";
                echo "<td align=center>$data[2]</td>";
                echo "<td align=center>$data[3]</td>";
                echo "<td align=center>$data[4]</td>";
                echo "<td align=center>$data[5]</td>";
                echo "<td align=center><button class='w3-btn w3-red w3-small w3-round-xxlarge' onclick=\"remove('$data[0]');\">Drop</button>&nbsp;<button class='w3-btn w3-blue-grey w3-small w3-round-xxlarge' onclick=\"alter('$data[0]','$data[1]');\"> Edit</button></td>";
                echo "</tr>";
            }

        }
        else {
            echo "Database does not exist";
        }
        break;

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


    case "modifyColumn":
        $DB_Name=$_POST['dbName'];
        $query_Stat=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            $sql = $query_Stat;
            if ($conn->query($sql) === TRUE) {
                echo "Column(s) modified successfully";
            } else {
                echo "Error while modifying column(s) " . $conn->error;
            }
        }
        else {
            echo "Database is not selected..!";
        }

        break;

    case "renameTable":
        $DB_Name=$_POST['dbName'];
        $query_Stat=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if($conn->query($query_Stat)===TRUE){
                echo "Table renamed successfully";
            }
            else{
                echo "error occured while renaming table. Try again..";
            }
        }
        else {
            echo "Database does not exist";
        }
        break;

    case "dropColumn":
        $DB_Name=$_POST['dbName'];
        $query_Stat=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if($conn->query($query_Stat)===TRUE){
                echo "Column Dropped successfully";
            }
            else{
                echo "Error occured while dropping the column. Try again..";
            }
        }
        else {
            echo "Database does not exist";
        }
        break;

    case "descTbInsertion":

        $DB_Name = $_POST['dbName'];
        $tb_Name = $_POST['tbName'];
        $list = array();
        if($conn->select_db($DB_Name))
        {
            $query = "DESCRIBE $tb_Name";
            $result = $conn->query($query);
            $rowCount = $result->num_rows;
            for($i=0; $i<$rowCount; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQL_NUM);
                $list[$i] = $row[0];
            }
            echo json_encode($list);

        }
        else {
            echo "Database is not selected..!";
        }

        /* free result set */
        $result->free();
        break;

    case "insertionDB":
        $DB_Name = $_POST['dbName'];
        $tb_Name = $_POST['tbName'];
        $sql = $_POST['queryInsert'];
        if($conn->select_db($DB_Name))
        {
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


        }
        else {
            echo "Database is not selected..!";
        }
        $conn->close();
        break;
case "selectall":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	if($conn->select_db($DB_Name))
	{
		$result=mysqli_query($conn,$query_Stat);
		
		while($data = mysqli_fetch_row($result))
		{
			echo "<tr>";
			for($i=0;$i<count($data);$i++)
			{
				echo"<td>$data[$i]<td>";
			}
			$count1=count($data);
			$count1=$count1-1;
			echo "<td><button id='' class='w3-btn w3-round-xxlarge w3-small w3-blue-grey' onclick=\"update(";
			for($i=0;$i<count($data);$i++)
			{

				echo "'".$data[$i]."',";
				
			}
			echo")\">update</button></td>";
			echo "</tr>";
		}
		
		
	}
	else {
		echo "Database does not exist";
	}
    default:
        echo "Nothing to show";
}

?>
