<?php

include 'dbconnect.php';

$notTrim = $_POST['Query'];
$sql = ltrim($notTrim);
$arr = explode(" ",$sql);
$i = 0;
$first = strtolower($arr[0]);


switch ($first)
{
    case "create":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Created successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }


        break;

    case "drop":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Droped successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error . "</p><br><br>";
            }



        break;

    case "alter":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Altered successfully ...... :)</p><br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }


        break;

    case "truncate":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Truncate successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }


        break;

    case "select":


            $result=mysqli_query($conn,$sql);

            echo "<table class = 'w3-table w3-striped w3-hoverable w3-border-left w3-border-right w3-border-bottom'>";
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
            echo "</table>";
            echo "<br>";
            $result->free();


        $conn->close();

        break;

    case "insert":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>New record inserted successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }



        break;

    case "delete":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Deletion successful ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }



        break;

    case "update":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Updated successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }


        break;

    case "rename":


            if ($conn->query($sql) === TRUE) {
                echo "<p class=' w3-text-green'>Renamed successfully ...... :)</p> <br><br>";
            } else {
                echo "<p class=' w3-text-red'><b>Erorrs : </b> " . $conn->error. "</p><br><br>";
            }



        break;

    default:
        echo "<p class=' w3-text-red'>Invalid Query ...... :( </p><br><br>";
}

?>
