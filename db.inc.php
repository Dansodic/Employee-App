<?php 
        $hostname = "*******"; //name of host or ip address
        $username = "********"; //mysql username
        $password = "*******"; //mysql password
        
        $dbname = "********"; //database name
            
        $con = mysqli_connect($hostname,$username,$password,$dbname);
    
    if(!$con)
    {
        die ( "Failed to connect" . mysqli_connect_error());
    }
  
    ?>