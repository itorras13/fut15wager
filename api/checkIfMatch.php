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

$checkUserID = mysql_query("SELECT matchID FROM matches WHERE status=0 AND player1 ='" .$q. "'");

if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
if (mysql_num_rows($checkUserID) != 0) {
    echo "delete";
}
else {
    echo "create";
}


mysql_close($dbhandle);

header("Location: http://localhost:8888/myprofile.html",TRUE,303);

?>