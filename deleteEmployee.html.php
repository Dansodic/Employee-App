<!DOCTYPE html>
<html>
<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		deleteEmployee.html.php
Purpose:	used to delete an employee from the system
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

<script>
//Used to populate the form fields with information from the listbox
function populate()
{
var sel = document.getElementById("listbox");
var result;
result = sel.options[sel.selectedIndex].value;
var personDetails = result.split('#');
document.getElementById("empId").value = personDetails[0];
document.getElementById("firstname").value = personDetails[1];
document.getElementById("surname").value = personDetails[2];
document.getElementById("dob").value = personDetails[3];
document.getElementById("address").value = personDetails[4];
document.getElementById("phonenumber").value = personDetails[5];
document.getElementById("jobtitle").value = personDetails[6];
document.getElementById("loginname").value = personDetails[7];
}
//Confirm the user wants to delete the employee. Also makes sure you can't delete your own account.
function confirmCheck()
{
var Seslogin = '<?php echo $_SESSION['user'];?>';
var delLogin = document.getElementById("loginname").value;
if(Seslogin == delLogin)
{
    alert("Can't delete own account");
    return false;
}

var response;
response = confirm('Are you sure you want to delete this person?');
if (response)
{
	document.getElementById("empId").disabled = false;
	document.getElementById("firstname").disabled = false;
	document.getElementById("surname").disabled = false;
	document.getElementById("dob").disabled = false;
    document.getElementById("address").disabled = false;
	document.getElementById("phonenumber").disabled = false;
	document.getElementById("jobtitle").disabled = false;
	document.getElementById("loginname").disabled = false;
	return true;
 }
else 
 {
	populate();
	return false;
 }
 }
</script>

<p id = "display"> </p>

<form id="form" action="deleteEmployee.php" onsubmit="return confirmCheck()" method="post">
	<h1 class = "h1"> Delete an Employee </h1>
	<h4 class = "h1"> Please select an employee and then click the delete button </h4>
<?php include 'deleteEmployeeListbox.php'; ?>
<label class="label">Employee Id </label>
<input class="forminput" type = "text" name = "empId" id = "empId"  disabled><br><br>
<label class="label">First Name </label>
<input class="forminput" type = "text" name = "firstname" id = "firstname"  disabled > <br><br>
<label class="label">Surname</label>
<input class="forminput" type="text" name = "surname" id = "surname" disabled> <br><br>
<label class="label">Date of Birth </label>
<input class="forminput" type = "date" name = "dob" id = "dob"  title = "format is dd-mm-yyyy" disabled><br><br>
<label class="label">Address </label>
<input class="forminput" type = "text" name = "address" id = "address"  disabled > <br><br>
<label class="label">Phone Number</label>
<input class="forminput" type="text" name = "phonenumber" id = "phonenumber" disabled> <br><br>
<label class="label">Job Title </label>
<input class="forminput" type = "text" name = "jobtitle" id = "jobtitle"  disabled > <br><br>
<label class="label">Login Name</label>
<input class="forminput" type="text" name = "loginname" id = "loginname" disabled> <br><br>
<br><br>
<input class ="btn" id= "submit" type="submit"  value="Delete Person">
</form>

</body>
</html>