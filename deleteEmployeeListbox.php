<?php
include "db.inc.php";

$sq2 = "SELECT empId, surname, firstname, dob, address, phonenumber, jobtitle, loginname FROM EmpTable WHERE deletedFlag = 0";

if (!$result = mysqli_query($con, $sq2))
{
    die('Error in querying the database' . mysqli_error($con));
}

echo "<br><select class='forminput' name = 'listbox' id = 'listbox' onclick = 'populate()'>";

while ($row = mysqli_fetch_array($result))
{
    $id = $row['empId'];
    $fname = $row['firstname'];
    $sname = $row['surname'];
    $dateOfBirth = $row['dob'];
    $dob = date_create($row['dob']);
    $dob = date_format($dob, "Y-m-d");
    $address = $row['address'];
    $phonenumber = $row['phonenumber'];
    $jobtitle = $row['jobtitle'];
    $loginname = $row['loginname'];
    
    $allText = "$id#$fname#$sname#$dob#$address#$phonenumber#$jobtitle#$loginname";
    echo "<option value = '$allText'>$id $fname $sname</option>";
    
}

echo "</select>";
mysqli_close($con);

?>