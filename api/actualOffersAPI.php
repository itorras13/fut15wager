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
if(mysql_num_rows($result) == 0) {
    echo "none";
}
else{
	echo "<br><br><table><tr><th>Player</th><th>Info</th><th>Date</th><th>Accept</th><th>Decline</th></tr>";
	while ($row = mysql_fetch_array($result)) {
		//Changes date to just month-day-year
		$phpdate = strtotime( $row{'dayMade'} );
		$date = date( 'F j', $phpdate );
		$result2 = mysql_query("SELECT firstName,lastName FROM users WHERE id=" .$row{'playerFrom'});
		$row2 = mysql_fetch_array($result2); 
		$name = $row2{'firstName'} . " " . $row2{'lastName'};
	 	echo "<tr><td class='normaltd'><a target='_blank' class='td-link' href='otherprofile.html?id=" .$row{'playerFrom'} . "'>" . $name . "</a></td><td class='normaltd'>" . $row{'info'} . "</td><td class='normaltd'>" . $date ."</td>";
	 	echo "<td class='buttontd'><center><button onclick=\"location.href='/api/acceptOffer.php?q="  .$q. "&q2=" .$row{'playerFrom'} . "&offerId=" .$row{'offerID'} . "&match=" .$row{'matchNumber'}. "'\"class='shabu-button signup-button blue td'>Accept</button></center></td>";
	 	echo "<td class='buttontd'><center><button onclick=\"location.href='/api/declineOffer.php?q="  .$row{'offerID'}. "'\"class='shabu-button signup-button blue td'>Decline</button></center></td></tr>";
	}
}

mysql_close($dbhandle);

?>
