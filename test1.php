<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-colors-signal.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-colors-food.css">


<?php
	$db=$_REQUEST['db'];
	$tb=$_REQUEST['tb'];
	$con=mysqli_connect('localhost','root','',$db);
	$sql="SHOW COLUMNS FROM $tb;";
	$query=@mysqli_query($con,$sql) or die(mysqli_error($con));
	$str= "<table border='1px'>";
	$str.="<tr>";
	$str.="<th>COLUMN</th><th>INSERT </th>";
	$str.= "</tr>";
	$rowcount=@mysqli_num_rows($query);

	
	for ( $i=1;$i<=$rowcount;$i++)
	{	$row=mysqli_fetch_array($query);
		$str.= "<tr>";
		$str.= "<td>".$row[0]."</td>";
		//$str.= "<td>";
		//$str.= "<input type='text' name='ip' id='ip[]' </input></td>";
		$str.= "<td>";
		$str.= "<input type='text' name='ip' id='ip$i' </input></td>";
		
		$str.= "</tr>";
	}

	$str.= "</table>";
	$str.= "<input type='button' name='ip' id='b' value='INSERT VALUES' class='w3-btn w3-signal-red w3-round-xlarge' onclick='f4(this.name,$rowcount)'>";
	
	
	echo $str;
?>
</html>