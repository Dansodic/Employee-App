<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		deleteEmployee.php
Purpose:	deletes an employee from the system if they aren't logged in.
-->
<?php
include 'db.inc.php';
date_default_timezone_set("Europe/Dublin");
session_start();
$_SESSION['user'];

//Returns the last login record for the employee where they have not yet logged out.
$logOutSQL = "SELECT * FROM EmpLogin WHERE loginName = '$_POST[loginname]' AND logoutTime = '00:00:00' ORDER BY logoutTime DESC LIMIT 1";
if(! mysqli_query($con,$logOutSQL))
{
    echo "Error" . mysqli_error($con);
}
else
{
    if(mysqli_affected_rows($con) >= 1)
    {
        echo "User is currently logged in and can't be deleted.";
    }
	else
	{
		//Updates the table to reflect the user is now deleted.
		$sql = "UPDATE EmpTable SET deletedFlag = 1 WHERE empId = '$_POST[empId]'";

		if(! mysqli_query($con,$sql))
		{
			echo "Error" . mysqli_error($con);
		}
		else
		{
			if(mysqli_affected_rows($con) != 0)
			{
				echo mysqli_affected_rows($con) . " record(s) updated <br>";
			}
			else
			{
				echo "No records were changed";
			}
		}
	}
}

mysqli_close($con);

?>

<form action="deleteEmployee.html.php" method="post">
<input type="submit" value="Return to pervious screen">

</form>