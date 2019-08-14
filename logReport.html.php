<!DOCTYPE html>
<html>
<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		logReport.html.php
Purpose:	A form used to select the details of the employee and date range for the login report.
-->
<head>
<?php include 'nav.html.php';?>
   <link rel="stylesheet" href="style.css">
<?php 
session_start();
$_SESSION['user'];
if(!isset($_SESSION['user'])) //checks if the user is logged in	
{
	header("Location: loginScreen.php");
}
?>
</head>
<body>

<h2 class='h1'> Login Report</h2>
<h2 class='h1'>Please Enter the desired details to produce the login report</h2>

<script>

function populate()
{
var sel = document.getElementById("listbox");
var result;
result = sel.options[sel.selectedIndex].value;
var personDetails = result.split('#');
document.getElementById("name").value = personDetails[0];
document.getElementById("username").value = personDetails[2];

}
function confirmCheck()
{


var response;
response = confirm('Are you sure you want to produce the report?');
if (response)
{
	document.getElementById("name").disabled = false;
	document.getElementById("username").disabled = false;

	return true;
 }
else 
 {
	populate();
	return false;
 }
 }
</script>

<form action="logReport.php" onsubmit="return confirmCheck()" method="post">
<?php include 'logReportListbox.php'; ?>
<label class='label'>Employee Name </label>
<input class='forminput' type = "text" name = "name" id = "name"  disabled><br><br>
<label class='label'>Employee login Name </label>
<input class='forminput' type = "text" name = "username" id = "username"  disabled><br><br>
<label class='label'>Date from </label>
<input class='forminput' type = "date" name = "datestart" id = "datestart"   > <br><br>
<label class='label'>Date Until</label>
<input class='forminput' type="date" name = "dateend" id = "dateend" > <br><br>

<br><br>
<input class ="btn" id= "submit" type="submit"  value="Produce Report">
</form>

</body>
</html>