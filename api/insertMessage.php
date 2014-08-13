<?php

$matchId = $_POST['qParam1'];
$uid = $_POST['uid1']; 
$message = $_POST['message1'];
				
$username = "root";
$password = "root";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

 date_default_timezone_set('America/Monterrey');
$date = date('Y-m-d H:i:s ', time());
mysql_query("INSERT INTO messages (matchID, playerID, message,dayMade)VALUES('$matchId', '$uid', '$message','$date')") or die(mysql_error());  



mysql_close($dbhandle);

?>