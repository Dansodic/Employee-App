<! DOCTYPE html>
<!--
Author:		Daniel Kenny
Date:		March 2019
Name:		allEmployeesReport.php
Purpose:	A report of all employees not deleted
-->
<html>
<head>
	<?php include 'nav.html.php';?>
   <link rel="stylesheet" href="style.css"> 
</head>
<body>

<?php 
session_start();
$_SESSION['user'];
include "db.inc.php";
date_default_timezone_set('UTC');
if(!isset($_SESSION['user'])) //checks if the user is logged in	
{
	header("Location: loginScreen.php");
}
?>
<form action = "allEmployeesReport.php" method = "post" name = "reportForm">
<input type = "hidden" name = "choice">
</form>

<h1>Person Report</h1>
<h3>(Click a button to see the Person Report in the desired order)</h3>
<input type = 'button' id = "idButton" value = 'Order by Emp ID' 
onclick = 'idOrder()' title = 'Click here to see persons in reverse date of birth order'> 
<input type = 'button' id = "nameButton" value = 'Surname Order' 
onclick = 'surnameOrder()' title = 'Click here to see Persons in alphabetical order of surname'>
<br>
<br>

<script>
//Orders the report by user id
function idOrder() 
{
	document.reportForm.choice.value = "ID";
	document.reportForm.submit();
}
//orders the report by users surname
function surnameOrder() 
{
	document.reportForm.choice.value = "Surname";
	document.reportForm.submit();
}
</script>
    
<?php 
//Defaults the order to surname
$choice = "Surname";
    
if(ISSET($_POST['choice']))
{
    $choice = $_POST['choice'];
}
if($choice =="ID")
{
?>
    <script>
	//enable the name button and disable the id button
	document.getElementById("idButton").disabled = true;
	document.getElementById("nameButton").disabled = false;	
	</script>
<?php 
	//return all emp records not deleted and order by empid
    $sql = "SELECT empId,surname,firstname,address,phonenumber,jobtitle,loginname FROM EmpTable WHERE deletedFlag = 0 order by empId ";
    produceReport($con, $sql);
}
else
{
?>
    <script>
	//disbale the name button and enable the id button
	document.getElementById("nameButton").disabled = true;
	document.getElementById("idButton").disabled = false;	
	</script>
<?php
	//return all emp records not deleted and order by surname
    $sql = "SELECT empId,surname,firstname,address,phonenumber,jobtitle,loginname FROM EmpTable WHERE deletedFlag = 0 order by surname";
    produceReport($con, $sql);
};
//Creates the report in a table based on the values returned from the sql
function produceReport($con, $sql)
{
    $result = mysqli_query($con, $sql);
    
    echo "<table class = 'report'>
        <tr><th>Id</th><th>Surname</th><th>First Name</th><th>Address</th><th>Phone Number</th><th>Job Title</th><th>Login Name</th></tr>";
    while ($row = mysqli_fetch_array($result))
    {
        //$date = date_create($row['DOB']);
        //$fDate = date_format($date,"d/m/Y");
        
        echo "<td>" . $row['empId'] . "</td>
         <td>" . $row['surname'] . "</td>
         <td>" . $row['firstname'] . "</td>
         <td>" . $row['address'] . "</td>
         <td>" . $row['phonenumber'] . "</td>
         <td>" . $row['jobtitle'] . "</td>
         <td>" . $row['loginname'] . "</td>
         </tr>";
    }
    echo "</table>";
}
mysqli_close($con);
?>
</body>

</html>