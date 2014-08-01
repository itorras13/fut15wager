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
$result = mysql_query("SELECT * FROM offers WHERE open>0 AND playerTo='" .$q."' ORDER BY dayMade DESC");
while ($row = mysql_fetch_array($result)) {
	//Changes date to just month-day-year
	$phpdate = strtotime( $row{'dayMade'} );
	$date = date( 'F j', $phpdate );
	$result2 = mysql_query("SELECT firstName,lastName FROM users WHERE id=" .$row{'playerFrom'});
	$row2 = mysql_fetch_array($result2); 
	$name = $row2{'firstName'} . " " . $row2{'lastName'};
 	echo "<tr><td class='normaltd'><a target='_blank' class='td-link' href='otherprofile.html?id=" .$row{'playerFrom'} . "'>" . $name . "</a></td><td class='normaltd'>" . $row{'info'} . "</td><td class='normaltd'>" . $date ."</td>";
 	echo "<td class='buttontd'><center><input class='shabu-button signup-button blue td' type='button' id='submit' value='Accept'/></center></td>";
 	echo "<td class='buttontd'><center><input class='shabu-button signup-button blue td' type='button' id='submit' value='Decline'/></center></td></tr>";
}

mysql_close($dbhandle);

?>
