<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		logReport.php
Purpose:	generates a login report from the posted values.
-->
<?php include 'nav.html.php';?>
   <link rel="stylesheet" href="style.css">
<?php
include "db.inc.php";

	$emp = $_POST['username'];
    
    $date1 = date_create($_POST['datestart']);
    $fDate1 = date_format($date1,"Y-m-d");

    $date2 = date_create($_POST['dateend']);
    $fDate2 = date_format($date2,"Y-m-d");

	//sql to select the details required to make the report for the details of the employee posted.
    $sql = "SELECT loginDate,loginTime,logoutTime,duration FROM EmpLogin WHERE loginName = '$emp' AND loginDate >= '$fDate1' AND loginDate <='$fDate2'";
    produceReport($con, $sql);

//Creates the report in a HTML table and displayes it to the user.
function produceReport($con, $sql)
{
    $result = mysqli_query($con, $sql);
    
    echo "<table>
        <tr><th>Login Date</th><th>login Time</th><th>logout Time</th><th>Duration</th></tr>";
    while ($row = mysqli_fetch_array($result))
    {   
        echo "<td>" . $row['loginDate'] . "</td>
         <td>" . $row['loginTime'] . "</td>
         <td>" . $row['logoutTime'] . "</td>
         <td>" . $row['duration'] . "</td>
         </tr>";
    }
    echo "</table>";
}
mysqli_close($con);
?>

<form action="logReport.html.php" method="post">
<input type="submit" value="Return to pervious screen">

</form>