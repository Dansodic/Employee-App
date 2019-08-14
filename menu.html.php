<link rel="stylesheet" href="style.css"> 
<?php
include 'nav.html.php'; 
session_start();
include "db.inc.php";
if(!isset($_SESSION['user'])) //checks if the user is logged in	
{
	header("Location: loginScreen.php");
}
date_default_timezone_set("Europe/Dublin");
?>

<h2 class = "h1">Main Menu</h2>
