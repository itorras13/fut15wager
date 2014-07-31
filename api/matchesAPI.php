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
$result = mysql_query("SELECT dayMade,title,player1 FROM matches WHERE complete=0 AND system='" .$system."' ORDER BY dayMade DESC");
//fetch tha data from the database
//date_default_timezone_set('Asia/Hong_Kong');
while ($row = mysql_fetch_array($result)) {
	//Changes date to just month-day-year
	$phpdate = strtotime( $row{'dayMade'} );
	$date = date( 'F j', $phpdate );
	$result2 = mysql_query("SELECT firstName,lastName FROM users WHERE id=" .$row{'player1'});
	$row2 = mysql_fetch_array($result2); 
	$name = $row2{'firstName'} . " " . $row2{'lastName'};
 	echo "<tr><td>" . $row{'title'} . "</td><td><a class='td-link' href='otherprofile.html?id=" .$row{'player1'} . "'>" . $name . "</a></td><td>" . $date ."</td></tr>";
}

mysql_close($dbhandle);

?>