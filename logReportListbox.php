<?php
include "db.inc.php";

$sq2 = "SELECT firstname, surname, loginname FROM EmpTable WHERE deletedFlag = 0";

if (!$result = mysqli_query($con, $sq2))
{
    die('Error in querying the database' . mysqli_error($con));
}

echo "<br><select class='forminput' name = 'listbox' id = 'listbox' onclick = 'populate()'>";

while ($row = mysqli_fetch_array($result))
{
    $fname = $row['firstname'];
    $sname = $row['surname'];
    //$dateOfBirth = $row['dob'];
    //$dob = date_create($row['dob']);
    //$dob = date_format($dob, "Y-m-d");
    $loginname = $row['loginname'];
    
    $allText = "$fname#$sname#$loginname";
    echo "<option value = '$allText'>$fname $sname $loginname</option>";
    
}

echo "</select>";
mysqli_close($con);

?>