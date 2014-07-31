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

$result = mysql_query("SELECT system FROM users WHERE id=" .$q);
while ($row = mysql_fetch_array($result)) {
	$system = $row{'system'};
}

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM matches WHERE complete=0 AND system='" .$system."'");
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
   echo "Sytem: " . $row{'system'} . "<br>Title: " . $row{'title'};
   //echo json_encode(array("message1" => "Sytem: " . $row{'system'} . "<br>Username: " . $row{'username'}, "message2" => $row{thumbsUp} . " Thumbs Up", "message3" => $row{thumbsDown} . " Thumbs Down", "message4" => $row{badSignal} . " Bad Signal"));
}

mysql_close($dbhandle);

?>