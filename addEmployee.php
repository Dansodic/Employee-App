<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		addEmployee.php
Purpose:	inserts the posted details to the database for a new employee
-->
<?php 
session_start();
$_SESSION['user'];
include 'db.inc.php';
date_default_timezone_set("Europe/Dublin");

//Return any records for a user with the posted login name
$check="SELECT * FROM EmpTable WHERE loginname = '$_POST[login]'";
$result = mysqli_query($con,$check);
//if a record exists,inform the user that name is taken.
if($result->num_rows >= 1) {
    echo "Username already exist, try something else.";
}

else
{
	//insert a new record of the details posted for a new user
    $newUser="Insert into EmpTable (surname, firstname, address, phonenumber, dob, jobtitle, loginname, password,passUpdated)
VALUES ('$_POST[surname]','$_POST[firstname]','$_POST[address]','$_POST[phonenumber]', '$_POST[dob]', '$_POST[job]', '$_POST[login]', '$_POST[password]',CURRENT_DATE)";

//insert a record of the password and username to the password table
$sql2="Insert into password (loginname, password)
VALUES ('$_POST[login]','$_POST[password]')";
    if (mysqli_query($con,$newUser) && mysqli_query($con,$sql2))
    {
        echo "You are now registered<br/>";
    }
    else
    {
        echo "Error adding user in database<br/>". mysqli_error($con);
    }
}

 ?>

<form action="addEmployee.html.php" method="post">
<br>
    <input type="submit" value="Return to insert page" />
</form>

