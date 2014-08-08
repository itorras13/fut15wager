<?php

$id = $_GET['id'];
$first = $_GET['first']; 
$last = $_GET['last'];
				
$username = "root";
$password = "root";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

$checkUserID = mysql_query("SELECT id FROM users WHERE id =" .$id);

if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
if (mysql_num_rows($checkUserID) != 0) {
    echo "already";
}
else {
	mysql_query("INSERT INTO users (id, firstName, lastName, thumbsUp,thumbsDown,badSignal,offers) VALUES('$id', '$first', '$last',0,0,0,0)") or die(mysql_error());  
	echo "new";
}


mysql_close($dbhandle);

?>