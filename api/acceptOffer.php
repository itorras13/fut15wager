<?php

$player1ID = $_GET['q'];
$player2ID = $_GET['q2'];
$offerId = $_GET['offerId'];
$match = $_GET['match'];
				
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
mysql_query("UPDATE offers SET open=0 WHERE matchNumber=" .$match);
mysql_query("UPDATE matches SET status=1,player2=" .$player2ID. " WHERE matchID=" .$match);
mysql_query("UPDATE matches SET status=4 WHERE player1=" .$player2ID);


mysql_close($dbhandle);

header("Location: /offers.html",TRUE,303);

?>