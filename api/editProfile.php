<?php


				
$username = "root";
$password = "root";
$hostname = "localhost"; 

$username1=$_POST['username1'];
$editSystem=$_POST['editSystem1'];
$q=$_POST['uid1'];
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

$checkUserID = mysql_query("UPDATE users SET username='" .$username1. "', system='" .$editSystem. "' WHERE id=" .$q);

if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
else{
	echo "Your profile have been saved";
}



mysql_close($dbhandle);

?>