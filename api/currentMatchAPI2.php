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
$result = mysql_query("SELECT dayMade,title,info FROM matches WHERE status=0 AND player1=" .$q);
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
	$i=1;
   // echo "Sytem: " . $row{'system'} . "<br>Username: " . $row{'username'};
	$phpdate = strtotime( $row{'dayMade'} );
	$date = date( 'F j', $phpdate );
    echo "<span id='red'>Open game:</span> <br>Created:<span id='red'> " .$date. ".</span> <br>Title:<span id='red'> " .$row{'title'}. "</span><br> Info:<span id='red'> " .$row{'info'} ;
}
if($i==0){
	echo "No current games open.";
}

mysql_close($dbhandle);

?>