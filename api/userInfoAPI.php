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
	$name = $row{'firstName'}. " " .$row{'lastName'};
   echo json_encode(array("message7" => $name, "message6" => $row{'offers'}, "message5" => $row{'system'}, "message1" => "Sytem: " . $row{'system'} . "&nbsp&nbsp&nbsp&nbsp&nbsp<span style='visibility: hidden' id='editLink'><a href='#' onclick='editProfile()' class='edit'><i class='fa fa-pencil-square-o'></i></a></span> <br>Gamertag: " . $row{'gamerTag'} . "<br>Email: " . $row{'email'}, "message2" => $row{thumbsUp} . " Thumbs Up", "message3" => $row{thumbsDown} . " Thumbs Down", "message4" => $row{badSignal} . " Bad Signal"));
}

mysql_close($dbhandle);

?>