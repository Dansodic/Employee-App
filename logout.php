<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		logout.php
Purpose:	logs the user out of the app and updates the database to reflect this.
-->
<?php
session_start();
$_SESSION['user'];
include 'db.inc.php';
date_default_timezone_set("Europe/Dublin");
//sql to update the EmpLogin table with the logout time for the current session
$sql = "UPDATE EmpLogin SET logoutTime = CURRENT_TIME WHERE loginName = '$_SESSION[user]' AND loginTime = '$_SESSION[timestamp]'";

//error checking to alert the user to any error connceting =
if(!mysqli_query ($con,$sql))
    {
        die ("An error occured with the sql query " . mysqli_error($con));
    }
//sql to calculate the duration of the login session and then add it to the EmpLogin table
 $sql3 = "UPDATE EmpLogin SET duration = TIMEDIFF(logoutTime, loginTime) WHERE loginName = '$_SESSION[user]' AND loginTime = '$_SESSION[timestamp]'";
	if(!$result =mysqli_query ($con,$sql3))
    {
        die ("An error occured with the sql query Update " . mysqli_error($con));
    }
    session_destroy();//Destroy the current session before logging out
	echo "<h1 class='h1'>You have logged out</h1>";
	echo "<h1 class='h1'>You'll be redirected in 3 seconds...</h1>";
	header("Refresh:3; url=loginScreen.php");//Redirects the user back to the login screen 3 seconds after being logged out



mysqli_close($con);
    ?>