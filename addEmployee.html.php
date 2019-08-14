<html>
<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		addEmployee.html.php
Purpose:	Allows the user to add an employee to the system
-->
<head>
<?php 
session_start();
$_SESSION['user'];

if(!isset($_SESSION['user'])) //checks if the user is logged in	
{
	header("Location: loginScreen.php");
}
	
?>
	<?php include 'nav.html.php';?>
   <link rel="stylesheet" href="style.css"> 
</head>
<body>	
<script>
function confirmCheck()
{
//get the value of the dob field and store it in a variable Bdate
    var Bdate = document.getElementById('dob').value;
    //convert the Bdate variable to date type
    var Bday = +new Date(Bdate);
    //calculate the age based on the date of birth and current date
    var age = ~~ ((Date.now() - Bday) / (31557600000)); //~~ used to return number of days between the millennium and a given date
if(age < 16)
{
	alert("Staff member is under the age of 16");
	return false;
}
var response;
response = confirm('Are you sure you want to save these changes?');
if (response)
{	
	return true;
 }
else 
 {
	return false;
 }
}
</script>
 <form id="form" action="addEmployee.php" onsubmit="return confirmCheck()" method="post">
	 <h1 class = "h1"> Add Employee </h1>
    <p><label class="label"> First Name
        <input class="forminput" type="text" name="firstname" id="firstname" pattern = "[a-zA-Z ]{1,30}" autofocus title = "Name should contain letters and spaces only" autocomplete="off" required/>
        </label>
    </p>
	 
     <p><label class="label"> Surname
        <input class="forminput" type="text" name="surname" id="surname" pattern = "[a-zA-Z ]{1,30}" title = "surname should contain letters and spaces only" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Address
        <input class="forminput" type="text" name="address" id="address"  required title = "Enter Address" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Phone Number
        <input class="forminput" type="text" name="phonenumber" id="phonenumber" pattern="[0-9]{3}-[0-9]{7}" title = "Format: 123-4567890" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Date of Birth
        <input class="forminput" type="date" name="dob" id="dob"  required title = "Enter Date of Birth" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Job Title
        <input class="forminput" type="text" name="job" id="job"  pattern = "[a-zA-Z ]{1,30}" title = "Enter Job Title" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Login Name
        <input class="forminput" type="text" name="login" id="login"  required title = "Enter A Login Name" autocomplete="off" required/>
        </label>
    </p>
     
     <p><label class="label"> Password
        <input class="forminput" type="password" name="password" id="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
        </label>
    </p>
     <br>
     
     <input class ="btn" type="submit" value="Submit"/>
     <input class ="btn" type="reset" value="Clear"/>
    
     <p></p>
</form>
</body>
</html>