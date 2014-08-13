<?php

$q = $_GET['q'];
$player1 = $_GET['player1'];
$player2 = $_GET['player2'];
				
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
$result = mysql_query("SELECT * FROM messages WHERE matchID=" .$q. " ORDER BY dayMade ASC");
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
	$phpdate = strtotime( $row{'dayMade'} );
	$date = date( 'M, d H:i', $phpdate );
	if($row{'playerID'}==$player1){
		if($i==1){
			echo "<br>";
		}
		echo "<span class='playerOne'>" .$row{'message'}. "</span><br><span class='playerOneDate'>" .$date. "</span><br>";
		$i=1;
	}
	else{
		if($i==2){
			echo "<br>";
		}
		echo "<span class='playerTwo'>" .$row{'message'}. "</span><br><span class='playerTwoDate'>" .$date. "</span><br>";
		$i=2;
	}
}
if($i==0){
	echo "No messages";
}

mysql_close($dbhandle);

?>