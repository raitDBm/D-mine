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
  $DB_Name=$_POST['dbName'];

    if($conn->select_db($DB_Name))
    {
        $result=mysqli_query($conn,$Sel_Cmd);

        echo "<tr>";
        while ($fieldinfo=mysqli_fetch_field($result))
        {

            echo"<th> $fieldinfo->name </th>";


        }
        echo "</tr>";

        while($data = mysqli_fetch_row($result))
        {

            echo "<tr>";
            for($i=0;$i<count($data);$i++)
            {
                echo"<td>$data[$i]</td>";
            }

            echo "</tr>";

        }
        $result->free();

    }
    else {
        echo "Database does not exist";
    }
    $conn->close();
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
	break;
case "updateselectall":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	if($conn->select_db($DB_Name))
	{
		$result=mysqli_query($conn,$query_Stat);
		$primarykey = mysqli_query($conn,"SHOW KEYS FROM $tablename WHERE Key_name = 'PRIMARY'");
		$primarykeydata = mysqli_fetch_row($primarykey);
		$primarykeyname = $primarykeydata[4];

		//echo headings
		echo "<tr>";
		while ($fieldinfo=mysqli_fetch_field($result))
		{
			echo"<th> $fieldinfo->name </th>";
			echo"<th></th>";
		}
		echo "<th></th></tr>";
			
		while($data = mysqli_fetch_array($result,MYSQL_BOTH))
		{
			
			
			echo "<tr>";

			for($i=0;$i<count($data)-count($data)/2;$i++)
			{
				echo"<td>$data[$i]<td>";
			}
            echo "<td><button id='' class='w3-btn w3-round-xxlarge w3-small w3-blue-grey' onclick=\"update('".$primarykeyname."',".$data[$primarykeyname].")\">Update</button></td>";
			echo "</tr>";
		}
		
		
	}
	else {
		echo "Database does not exist";
	}
	break;

case "updatemodal":


	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	$pkeyname = $_POST['pkeyname'];
	$pkeyval = $_POST['pkeyval'];

	if($conn->select_db($DB_Name))
    {
        $result=mysqli_query($conn,$query_Stat);
        echo "<tr>";
		$i=0;
        while ($fieldinfo=mysqli_fetch_field($result))
        {
            echo"<th id='h$i' > $fieldinfo->name </th>";
			$i++;
        }
        echo "</tr>";
        while($data = mysqli_fetch_row($result))
        {

            echo "<tr>";
            for($i=0;$i<count($data);$i++)
            {
                echo"<td ><input id='v$i'type='text' value='".$data[$i]."'></td>";
            }
            echo "</tr>";
			echo "<tr>";
            for($i=0;$i<count($data);$i++)
            {
                echo"<td ><input id='iv$i' class='w3-hide' type='text' value='".$data[$i]."'></td>";
            }
            
			echo "<tr class='w3-hide'><td><input type='text' id='count' value='".count($data)."'></td></tr>";
			echo "</tr>";
		}
		
        $result->free();
    }
    else {
        echo "Database does not exist";
    }
	break;
	
case "updatevalues":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
	{
		if($conn->query($query_Stat)===TRUE){
			echo "Values updated Successfully";
		}
		else{
			echo "Error occured. Try again.."; 
		}
	}
	else {
		echo "Database does not exist";
	}
	break;

case "deleteselectall":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	if($conn->select_db($DB_Name))
	{
		$result=mysqli_query($conn,$query_Stat);
		$primarykey = mysqli_query($conn,"SHOW KEYS FROM $tablename WHERE Key_name = 'PRIMARY'");
		$primarykeydata = mysqli_fetch_row($primarykey);
		$primarykeyname = $primarykeydata[4];

		//echo headings
		echo "<tr>";
		while ($fieldinfo=mysqli_fetch_field($result))
		{
			echo"<th> $fieldinfo->name </th>";
			echo"<th></th>";
		}
		echo "<th></th></tr>";
			
		while($data = mysqli_fetch_array($result,MYSQL_BOTH))
		{
			
			
			echo "<tr>";

			for($i=0;$i<count($data)-count($data)/2;$i++)
			{
				echo"<td>$data[$i]<td>";
			}
            echo "<td><button id='' class='w3-btn w3-round-xxlarge w3-small w3-blue-grey' onclick=\"deleterow('".$primarykeyname."',".$data[$primarykeyname].")\">Delete</button></td>";
			echo "</tr>";
		}
		
		
	}
	else {
		echo "Database does not exist";
	}
	break;

    case "CreateViewExecution":
        $DB_Name=$_POST['db_Name'];
        $query_Stat=$_POST['ViewCmd'];
        if($conn->select_db($DB_Name))
        {
            $sql = $query_Stat;
            if ($conn->query($sql) === TRUE) {
                echo "View created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
        }
        else {
            echo "Database is not selected..!";
        }
        break;

    case "delete":
	$DB_Name=$_POST['dbName'];
	$query_Stat=$_POST['Query'];
	if($conn->select_db($DB_Name))
	{
		if($conn->query($query_Stat)===TRUE){
			echo "Row deleted succesfully";
		}
		else{
			echo "Error occured. Try again.."; 
		}
	}
	else {
		echo "Database does not exist";
	}
	break;

    case "dropView":
        $drop_view=$_POST['dpViewName'];
        $DB_Name=$_POST['dbName'];
        $query_Stat=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if(mysqli_query($conn,$query_Stat) == true)
            {
                echo "View Dropped successfully";
            }
            else
            {
                echo "View not exist in database";
            }
        }
        else
        {
            echo "Database does not exist";
        }
        break;

    case "renameView":
        $DB_Name=$_POST['dbName'];
        $query_Stat=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if(mysqli_query($conn,$query_Stat) == true)
            {
                echo "View Rename sucessfully";
            }
            else
            {
                echo "View not exists in database";
            }
        }
        else
        {
            echo "Database does not exist";
        }
        break;

    case "getviewslist":
        $DB_Name=$_POST['dbName'];
        $query=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            $result = $conn->query($query);
            $rowCount = $result->num_rows;
            echo "<option value=''>Select View</option>";
            /* fetch associative array */
            for($i=0; $i<$rowCount; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQL_NUM);
                echo "<option value='".$row[0]."'>".$row[0]."</option>";
            }
            /* free result set */
            $result->free();
        }else{
            echo "Database does not exist";
        }
        break;
	case "getColumns":
        $DB_Name=$_POST['dbName'];
        $tb_Name=$_POST['tbName'];
        echo $tb_Name;
        $query_Stat="select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tb_Name'";
        // $list = array();tb
        if($conn->select_db($DB_Name))
        {
            
            $result = $conn->query($query_Stat);
            $rowCount = $result->num_rows;
            // echo "<option value='>Select Column</option>";
            echo "<option value=''>Select Column</option>";
            for($i=0; $i<$rowCount; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQL_NUM);
                echo "<option value='".$row[0]."'>".$row[0]."</option>";

            }
            //echo json_encode($list);

        }
        else {
            echo "Database is not selected..!";
        }

        /* free result set */
        $result->free();
        break;
        case "alter_index":
        $DB_Name=$_POST['dbName'];
        $query=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if(mysqli_query($conn,$query) == true)
            {
                echo "constraint added sucessfully";
            }
            else
            {
                echo "constraint not added try again";
            }
        }
        else
        {
            echo "Database is not selected";
        }
        break;
        case "drop_index":
        $DB_Name=$_POST['dbName'];
        $query=$_POST['Query'];
        if($conn->select_db($DB_Name))
        {
            if(mysqli_query($conn,$query) == true)
            {
                echo "constraint dropped sucessfully";
            }
            else
            {
                echo "constraint not dropped try again";
            }
        }
        else
        {
            echo "Database is not selected";
        }
        break;
    default:
        echo "Nothing to show";
}

?>
