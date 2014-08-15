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
// $result = mysql_query("SELECT open FROM offers WHERE open>0 AND playerTo=" .$q);
// //fetch tha data from the database
// $i=0;
// while ($row = mysql_fetch_array($result)) {
//    $i++;
// }
mysql_query("UPDATE matches SET status=4 WHERE status=0 AND player1=" .$q);


mysql_close($dbhandle);

header("Location:/myprofile.html",TRUE,303);

?>