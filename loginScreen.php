<!--
Author:		Daniel Kenny
Date:		April 2019
Name:		loginScreen.php
Purpose:	used to log a valid user into the app.
-->
<link rel="stylesheet" href="style.css"> 
<?php include "db.inc.php";
date_default_timezone_set("Europe/Dublin");
session_start();

if (isset($_POST['loginname']) && isset($_POST['password']))
{
    $attempts = $_SESSION['attempts'];
    
    $sql = "SELECT * FROM EmpTable WHERE loginName = '$_POST[loginname]' AND passWord = '$_POST[password]' AND deletedFlag = 0";
    
    if (!mysqli_query($con,$sql))
        echo "Error in query " . mysqli_error($con);
    else
    {
        if(mysqli_affected_rows($con)==0)
        {
            $attempts++;
            
            if($attempts <=3)
            {
                $_SESSION['attempts'] = $attempts;
                buildPage($attempts);
                
                echo "<h2 class='h1'>No record found with this login name and password combination - Please try again.</h2>";
            }
            else
            {
                echo "<h2 class='h1'>Sorry - You have used all 3 attempts<br> Shutting down...</h2>";
				header("Refresh:3; url=loginScreen.php");
            }
        }
        else
        {
			//sql to insert a new record with the login time and date along with the username
			$sq2 = "Insert into EmpLogin (loginName,loginDate,loginTime) VALUES ('$_POST[loginname]',CURRENT_DATE,CURRENT_TIME)";
			if (!mysqli_query($con,$sq2))
			{
        		echo "Error in query " . mysqli_error($con);
			}
			$timeStamp = date("H:i:s");
            //Sucessful login
            $_SESSION['user'] = $_POST['loginname']; //Session variable to keep track of the login name
            $_SESSION['timestamp'] = $timeStamp;  //for use with change password screen
            
			$sq3 = "SELECT firstname, surname, dob, passUpdated FROM EmpTable WHERE loginName = '$_SESSION[user]'";
			if (!$result =mysqli_query($con,$sq3))
        	echo "Error in query " . mysqli_error($con);
			while ($row = mysqli_fetch_array($result))
				{
					$fname = $row['firstname'];
					$sname = $row['surname'];
					$dob = $row['dob'];
					$passUpdated = $row['passUpdated'];

				}
			//SQL to check for records where password has not been updated in 28 days or more
$sqlpass1 = "SELECT * FROM EmpTable WHERE (DateDiff( CURRENT_DATE, passUpdated)) >= 28 AND loginname = '$_SESSION[user]'";
	if (!mysqli_query($con,$sqlpass1))
        echo "Error in query " . mysqli_error($con);
		//If a record exists for an outdated password stop the user from using the app and make them change password
    else if(mysqli_affected_rows($con)==1) {echo "<h2 class='h1'>Access Denied: Password must be updated before you can use the app.</h2><input class ='btn' type='button' value='Change Password' onclick='window.location = \"changePassSecure.php\"'>";}

else{
	//SQL to find if there is a week or less left to update password and warn the user to change password
$sqlpass2 = "SELECT * FROM EmpTable WHERE (DateDiff( CURRENT_DATE, passUpdated)) >= 21 AND (DateDiff( CURRENT_DATE, passUpdated)) < 28 AND loginname = '$_SESSION[user]'";
	if (!mysqli_query($con,$sqlpass2))
        echo "Error in query " . mysqli_error($con);
    else
    {
		//if affected rows is 1, warn the user to update password by end of the week
        if(mysqli_affected_rows($con)==1) {echo "<h2 class='h1'>Warning: Password should be updated before the end of the week.</h2>";}
}
	echo "<h2 class='h1'> Login Successful!</h2>";
	echo "<h2 class='h1'>Welcome ".$fname." ".$sname."."." It's </h2>"."<h2 class='h1'>".date("D/M/Y")."</h2>";
	
	//Check if today is the users birthday
	if(date('m-d') == substr($dob,5,5))
			{
				$today = date("Y-m-d");//format date to match format of database value
				//Calculate the age of the user
				$diff = date_diff(date_create($dob), date_create($today));
				//Check if it's an important birthday and if so echo out a greeting
			 	if($diff->format('%y') == '21'){echo "<h2 class='h1'>Enjoy your 21st on the weekend!</h2>";}
				else if($diff->format('%y') == '30'){echo "<h2 class='h1'> Happy birthday. Enjoy your 30th!</h2>";}
				else if($diff->format('%y') == '40'){echo "<h2 class='h1'>Happy birthday. Enjoy your 40th!</h2>";}
				else if($diff->format('%y') == '50'){echo "<h2 class='h1'>Happy birthday. Enjoy your 50th!</h2>";}
				else if($diff->format('%y') == '60'){echo "<h2 class='h1'>Happy birthday. Enjoy your 60th!</h2>";}
				else if($diff->format('%y') == '70'){echo "<h2 class='h1'>Happy birthday. Enjoy your 70th!</h2>";}
				else if($diff->format('%y') == '80'){echo "<h2 class='h1'>Happy birthday. Enjoy your 80th!</h2>";}
				else if($diff->format('%y') == '90'){echo "<h2 class='h1'>Happy birthday. Enjoy your 90th!</h2>";}
				else{echo "<h2 class='h1'>Happy Birthday!</h2>";}
			}
			else
			{
				//SQL to find if the cuurent users birtday is within the coming 7 days.
				$sqlBday = "SELECT * FROM EmpTable WHERE date(concat_ws('-', year(now()), month(dob), day(dob)))
			  BETWEEN CURDATE() - INTERVAL 0 WEEK AND CURDATE() + INTERVAL 1 WEEK AND loginname = '$_SESSION[user]'";
				if (!mysqli_query($con,$sqlBday))
					echo "Error in query " . mysqli_error($con);
				else
				{
					if(mysqli_affected_rows($con)==1)//if affected row is 1, check if birthday is on a Sat or Sun
					{
						//new date variable taking only the day and month from date of birth
						$bday2 = date("d-m-", strtotime($dob));
						//new date variable that concatenates $bday2 with the current year
						$dateNew = $bday2 . date("Y");
						//change $datenew to a date object
						$cc=date_create($dateNew);
						//take the day from the $dateNew variable and add it to a new date variable
						$dd = date("D", strtotime($dateNew));
						//echo"<BR>". $dd;
						
						//check if the day is a Sat or Sun
						if($dd == 'Sat' || $dd == 'Sun')
						{
							$today = date("Y-m-d");
							$diff = date_diff(date_create($dob), date_create($today));
							//echo 'Age is '.$diff->format('%y');
							if($diff->format('%y') == '20'){echo "<h2 class='h1'>Enjoy your 21st on the weekend!</h2>";}
							else if($diff->format('%y') == '29'){echo "<h2 class='h1'>Enjoy your 30th on the weekend!</h2>";}
							else if($diff->format('%y') == '39'){echo "<h2 class='h1'>Enjoy your 40th on the weekend!</h2>";}
							else if($diff->format('%y') == '49'){echo "<h2 class='h1'>Enjoy your 50th on the weekend!</h2>";}
							else if($diff->format('%y') == '59'){echo "<h2 class='h1'>Enjoy your 60th on the weekend!</h2>";}
							else if($diff->format('%y') == '69'){echo "<h2 class='h1'>Enjoy your 70th on the weekend!</h2>";}
							else if($diff->format('%y') == '79'){echo "<h2 class='h1'>Enjoy your 80th on the weekend!</h2>";}
							else if($diff->format('%y') == '89'){echo "<h2 class='h1'>Enjoy your 90th on the weekend!</h2>";}
							else{echo "<h2 class='h1'>Enjoy your birthday on the weekend!</h2>";}
						}
					}
				}
			}		
	
				echo "<h3 class='h1'>Do you want to change password or go directly to the Main Menu?</h3>
            
            <input class ='btn' type='button' value='Change Password' onclick='window.location = \"changePass.php\"'>
            <input class ='btn' type='button' value='Main Menu' onclick='window.location = \"menu.html.php\"'>";
			
			
}

        }
    }
}
else
{
    //building page for initial display
    $attempts = 1; //Screen will be displayed for first time
    $_SESSION['attempts'] = $attempts; //set session variables so that the number of attempts can be counted
    buildPage($attempts); //parameter passed so that a heading can display the number of attempts
};

function buildPage($att)
{
    echo "<body>
    
    <form id='form' action = 'loginScreen.php' method = 'post'>
    <h1 class='h1'>Employee App</h1>
    <h2 class='h1'>Attempt Number: $att</h2>
    <lable class='label' for='loginname'>Login Name</lable>
    <input class='forminput' type = 'text' name = 'loginname' id = 'loginname' autocomplete = 'off' /> <br><br>
    <lable class='label' for='password'>Password</lable>
    <input class='forminput' type = 'password' name = 'password' id = 'password'><br><br>
    <input class='forminput' type= 'submit' value = 'submit'>
    </form>";
}

mysqli_close($con);
?>