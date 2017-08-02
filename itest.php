<?php

$db=$_GET['database'];
$con=@mysqli_connect('localhost','root','',$db);
$sql="show tables from $db";
$result=@mysqli_query($con,$sql);
$rowcount=@mysqli_num_rows($result);
if($rowcount>0)
{	
	$str="<select name='table' id='table' onclick='f3(this.value)'>";
	$str.="<option value='tbnull'>select tb</option>";
	for($i=0;$i<=$rowcount-1;$i++)
	{
		mysqli_data_seek($result,$i);
		$row=mysqli_fetch_array($result);
		$str.="<option value='".$row[0]."'>".$row[0]."</option>";
	}
	$str.="</select>";
	echo $str;
}

?>
