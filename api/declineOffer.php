<?php

$q = $_GET['q'];
				
$username = "root";
$password = "root";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

mysql_query("UPDATE offers SET open=0 WHERE offerID=" .$q);


mysql_close($dbhandle);

header("Location: /offers.html",TRUE,303);

?>