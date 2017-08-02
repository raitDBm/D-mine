<?php

	$db=$_REQUEST['db'];
	$tb=$_REQUEST['tb'];
	$arr=$_REQUEST['array'];
	
	$count=$_REQUEST['count'];
    $val=array_shift($arr);
    $arr1=explode(',', $val);
    $val1 =implode(" ',' ",$arr1);
    


	$con=mysqli_connect('localhost','root','',$db);
	$sql1="SHOW COLUMNS FROM $tb;";
	$query=@mysqli_query($con,$sql1) or die(mysqli_error($con));
	$rowcount=@mysqli_num_rows($query);
	for ( $i=1;$i<=$rowcount;$i++)
	{	$row=mysqli_fetch_array($query);
		$col[]=$row[0];
	}
	$colmn =implode(" , ",(array)$col);
    if (!$con)
	{
		die(mysqli_error($con));
	}
	else
	{
	
	$sql="INSERT INTO $tb ($colmn) VALUES ('".$val1. "');";
	
	
	$result=mysqli_query($con,$sql);  
	if($result==0)
	{
		echo mysqli_error($con);
	}
	else
	echo "<h3>VALUES INSERTED SUCCUSSFULLY</h3>";
	}

	
?>