<?php

$q = $_GET['q'];
				
$username = "root";
$password = "root";
$hostname = "localhost"; 

$i =0;
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

//execute the SQL query and return records
$result = mysql_query("SELECT player1,player2,title,info,offerTaken FROM matches WHERE matchID=" .$q);
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
	echo json_encode(array("message5" => $row{'offerTaken'}, "message4" => $row{'player1'}, "message1" => $row{'player2'}, "message2" => $row{'title'}, "message3" => $row{'info'}));
}

mysql_close($dbhandle);

?>