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

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM users WHERE id=" .$q);
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
   echo $row{'firstName'}. " " .$row{'lastName'};
}



?>