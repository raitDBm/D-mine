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

    $tb=$_POST['tb'];
    $cn=$_POST['cn'];
    $dt=$_POST['dt'];
    $size=$_POST['size'];
    if($cn!='' && $dt!='' && $size!='')
    {
      $sql="ALTER TABLE $tb ADD $cn $dt($size);";

      if($conn->query($sql) === TRUE)
      {
        echo "column added successfully,refresh to see result...";
      }
      else
        echo "Error: " . $conn->error;

    }
    else
    echo "Enter value...";
    break;




case "createTable":

    $query_Stat=$_POST['Query'];


      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Table created successfully";
      } else {
          echo "Error creating table: " . $conn->error;
      }


    break;

case "DropTable":

	$query_Stat=$_POST['Query'];

      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Table dropped successfully";
      } else {
          echo "Error dropping table: " . $conn->error;
      }

    break;


case "DropDatabase":

	$query_Stat=$_POST['Query'];

      $sql = $query_Stat;
      if ($conn->query($sql) === TRUE) {
          echo "Database dropped successfully";
      } else {
          echo "Error dropping Database: " . $conn->error;
      }


    break;

case "TruncateTable":

	$query_Stat=$_POST['Query'];

		if($conn->query($query_Stat)=== TRUE){
			echo "Table truncated succesfully";
		}
		else{
			echo "error truncating database";
		}

	break;

case "SelectExecution":
  $Sel_Cmd=$_POST['SelCmd'];

        $result=mysqli_query($conn,$Sel_Cmd);

        echo "<br><br>";
        echo "<p><table class = 'w3-table w3-striped w3-hoverable w3-border-left w3-border-right w3-border-bottom'>";
        echo "<tr class='w3-blue'>";
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
        echo "</table></p>";

        $result->free();


    $conn->close();
  break;


    case "TbList":

        $list = array();
        $DBName = $_SESSION["roll_no"];
            $query = "show tables from $DBName";
            $result = $conn->query($query);
            $rowCount = $result->num_rows;
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

    case "desc":

        $query_Stat=$_POST['Query'];
        $tablename=$_POST['tName'];

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


        break;

    case "addColumn":

        $query_Stat=$_POST['Query'];

            if($conn->query($query_Stat)=== TRUE){
                echo "columns addded succesfully";
            }
            else{
                echo "error occured while adding tables. Try again..";
            }

        break;


    case "modifyColumn":

        $query_Stat=$_POST['Query'];

            $sql = $query_Stat;
            if ($conn->query($sql) === TRUE) {
                echo "Column(s) modified successfully";
            } else {
                echo "Error while modifying column(s) " . $conn->error;
            }


        break;

    case "renameTable":

        $query_Stat=$_POST['Query'];

            if($conn->query($query_Stat)===TRUE){
                echo "Table renamed successfully";
            }
            else{
                echo "error occured while renaming table. Try again..".$conn->error;
            }


        break;

    case "dropColumn":

        $query_Stat=$_POST['Query'];

            if($conn->query($query_Stat)===TRUE){
                echo "Column Dropped successfully";
            }
            else{
                echo "Error occured while dropping the column. Try again..";
            }


        break;

    case "desc_column_list":
        $query_Stat=$_POST['Query'];
        $tablename=$_POST['t_name'];

            $result=mysqli_query($conn,$query_Stat);
            echo "<option value=0>Select Column</option>";           

            while($data = mysqli_fetch_row($result))
            {
                echo "<option value='$data[0]'>".$data[0]."</option>";
                
            }


    break;

    case "Add_primary_key":
       $query_Stat=$_POST['Query'];
       $result = mysqli_query($conn,$query_Stat);
       if($result == true)
       {
            echo "Primary key sucessfully added";
       }
       else
       {
            echo "Primary key already exist OR Error in query fired";
       }

    break;
    case "Drop_primary_key":
       $query_Stat=$_POST['Query'];
       $result = mysqli_query($conn,$query_Stat);
       if($result == true)
       {
            echo "Primary Key successfully Droped";
       }
       else
       {
            echo "Primary key Doesn't exist OR Error in query fired";
       }

    break;
    case "Add_unique_key":
       $query_Stat=$_POST['Query'];
       $result = mysqli_query($conn,$query_Stat);
       if($result == true)
       {
            echo "Unique key sucessfully added";
       }
       else
       {
            echo "Unique key already exist OR Error in query fired";
       }

    break;

    case "Drop_unique_key":
       $query_Stat=$_POST['Query'];
       $result = mysqli_query($conn,$query_Stat);
       if($result == true)
       {
            echo "Unique Key successfully Droped";
       }
       else
       {
            echo "Unique key Doesn't exist OR Error in query fired";
       }

    break;

    case "Add_foreign_key":
      $query_Stat = $_POST['Query'];
      $result = mysqli_query($conn,$query_Stat);
      if($result == true)
      {
          echo "Foreign Key successfully Added";
      }
      else
      {
          echo "Foreign key doesn't Added ! Select correct reference table and Try again";
      }
    break;

    case "Drop_foreign_key":
      $query_Stat = $_POST['Query'];
      $result = mysqli_query($conn,$query_Stat);
      if($result == true)
      {
          echo "Foreign Key successfully Droped";
      }
      else
      {
          echo "Foreign Key doesn;t Droped";
      }
    break;

    case "descTbInsertion":


        $tb_Name = $_POST['tbName'];
        $list = array();

            $query = "DESCRIBE $tb_Name";
            $result = $conn->query($query);
            $rowCount = $result->num_rows;
            for($i=0; $i<$rowCount; $i++)
            {
                $result->data_seek($i);
                $finfo = $result->fetch_field_direct(1);
                $row = $result->fetch_array(MYSQL_NUM);
                $list[$i] = $row[0];
            }
            echo json_encode($list);



        /* free result set */
        $result->free();
        break;

    case "insertionDB":

        $tb_Name = $_POST['tbName'];
        $sql = $_POST['queryInsert'];

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }



        $conn->close();
        break;

case "selectall":

	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];

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



	break;
case "updateselectall":
	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];

		$result=mysqli_query($conn,$query_Stat);
		$primarykey = mysqli_query($conn,"SHOW index FROM $tablename WHERE Key_name = 'PRIMARY'");
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



	break;

	
case "updatemodal":

	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];
	$pkeyname = $_POST['pkeyname'];
	$pkeyval = $_POST['pkeyval'];


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

	break;

case "updatevalues":

	$query_Stat=$_POST['Query'];

		if($conn->query($query_Stat)===TRUE){
			echo "Values updated Successfully";
		}
		else{
			echo "Error occured. Try again..";
		}

	break;

case "deleteselectall":

	$query_Stat=$_POST['Query'];
	$tablename=$_POST['tName'];

		$result=mysqli_query($conn,$query_Stat);
		$primarykey = mysqli_query($conn,"SHOW index FROM $tablename WHERE Key_name = 'PRIMARY'");
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



	break;

    case "CreateViewExecution":

        $query_Stat=$_POST['ViewCmd'];

            $sql = $query_Stat;
            if ($conn->query($sql) === TRUE) {
                echo "View created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }

        break;

    case "delete":

	$query_Stat=$_POST['Query'];

		if($conn->query($query_Stat)===TRUE){
			echo "Row deleted succesfully";
		}
		else{
			echo "Error occured. Try again..";
		}

	break;

    case "dropView":
        $drop_view=$_POST['dpViewName'];

        $query_Stat=$_POST['Query'];

            if(mysqli_query($conn,$query_Stat) == true)
            {
                echo "View Dropped successfully";
            }
            else
            {
                echo "View not exist in database";
            }

        break;

    case "renameView":

        $query_Stat=$_POST['Query'];

            if(mysqli_query($conn,$query_Stat) == true)
            {
                echo "View Rename sucessfully";
            }
            else
            {
                echo "View not exists in database";
            }

        break;

    case "getviewslist":
            $DBName = $_SESSION["roll_no"];
            $query="SHOW FULL TABLES IN $DBName WHERE TABLE_TYPE LIKE 'VIEW'";

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

        break;


	case "logout":
		session_start();
		unset($_SESSION['roll_no']);
		session_destroy();
		break;

  case "getNO":

      $id = $_SESSION['roll_no'];
      $con2=mysqli_connect("localhost","root","","dmine") or die ('I cannot connect to the database because: ' . mysql_error());
      $sql = "SELECT name, roll_no FROM students WHERE roll_no = '$id' ";
      $result = $con2->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          $row = $result->fetch_array(MYSQLI_ASSOC);
              echo $row["roll_no"]." ";

      } else {
          echo "";
      }
      $con2->close();
      break;

    default:
        echo "Nothing to show";
}

?>
