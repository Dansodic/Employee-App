<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		changePass.php
Purpose:	used when the user wants to change their password. Does not have the navbar so the user is forced to reset password before using app
-->
  <link rel="stylesheet" href="style.css"> 
<?php include "db.inc.php";
date_default_timezone_set("Europe/Dublin");
session_start();
//echo '<link rel="stylesheet" href= "pass.css" typpe="text/css">';

if(isset($_SESSION['user'])) //checks if the user is logged in
{
    if(isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['confirmPass']))
    {
        $old = $_POST['oldPass'];
        $new = $_POST['newPass'];
        $confirm = $_POST['confirmPass'];
        
        $user = $_SESSION['user'];
        
        $sql = "SELECT * FROM EmpTable WHERE loginname = '$user' AND password = '$_POST[oldPass]'";
		
		$sqlPass3 = "SELECT passWord FROM password WHERE loginName = '$user' ORDER BY passWord DESC LIMIT 3 ";
		
$result = mysqli_query($con,$sqlPass3);
		
if (!$result = mysqli_query($con, $sqlPass3))
{
    die('Error in querying the database' . mysqli_error($con));
}

$sentToList = array();
while($row = mysqli_fetch_assoc($result)) { $sentToList[] = $row['passWord']; }
		print_r($sentToList);
        
        if(!mysqli_query($con,$sql))
            echo "Error in select query ".mysqli_error($con);
        else
        {
            if(mysqli_affected_rows($con) == 0)
            {
                buildPage($old,$new,$confirm);
                echo "<h2 class='h1'>Old password incorrect!</h2>";
            }
			else if (in_array($new, $sentToList))
				  {
					buildPage($old,$new,$confirm);
				 	echo "<h2 class='h1'>New Password can't be any of the last 3 passwords used!</h2>";
				  }
            else
            {
                if($_POST['newPass'] != $_POST['confirmPass'])
                {
                    buildPage($old,$new,$confirm);
                echo "<h2 class='h1'>New passwords do not match!</h2>";
                }

                else
                {
                    $sql = "UPDATE EmpTable SET password = '$_POST[newPass]',passUpdated = CURRENT_DATE WHERE loginname = '$user'";
                    if(!mysqli_query($con,$sql))
                        echo "Error in the update query ".mysqli_error($con);
					
                    else
                    {
                        if(mysqli_affected_rows($con) == 0)
                        {
                            buildPage($old,$new,$confirm);
                            echo "<h2 class='h1'>No changes made!</h2>";
                        }
                        else
                        {
							$sql2 = "INSERT password (loginName, passWord)VALUES ('$user', '$_POST[newPass]')";
                    if(!mysqli_query($con,$sql2))
					{
                        echo "Error in the update query ".mysqli_error($con);
					}
                            echo "<h2 class='h1'>Congrats, your password has been updated!</h2><BR>";
							echo "<h2 class='h1'>You will now be logged out in order to reauthenticate</h2>";
							
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
	header("Refresh:3; url=loginScreen.php");//Redirects the user back to the login screen 3 seconds after being logged out

                        }
                    }
                }
            }
        }
    }
    else
    {
        //building page for initial display
        buildPage("","","");
    }
}
else
{
    echo'<h2 class ="h1">You must be logged in to view this page! Redirecting...</h2>';
	header("Refresh:3; url=loginScreen.php");
}
function buildPage($o,$n,$c) //parameters are old password, new password and confirm password respectively
    //Parameters passed so that old values will remain in fields for amendment, rather than facing blank fields each time
{
    echo "<body>
    <form action = 'changePass.php' method = 'post'
    <h1 class='h1'>My System</h1>
    <h3 class='h1'>Change Password</h3>
    <label class='label' for 'oldPass'>Old Password</label>
    <input class='forminput' type = 'password' name = 'oldPass' id = 'oldPass' autocomplete = 'off' value = $o><br><br>
    <label class='label' for 'oldPass'>New Password</label>
    <input class='forminput' type = 'password' name = 'newPass' id = 'newPass' autocomplete = 'off' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' title='Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters' required value = $n><br><br>
    <label class='label' for 'oldPass'>Confirm New Password</label>
    <input class='forminput' type = 'password' name = 'confirmPass' id = 'confirmPass' autocomplete = 'off' value = $c><br><br>
    <input class ='btn' type = 'submit' value = 'Submit'>
    </form>";
}
mysqli_close($con);
?>