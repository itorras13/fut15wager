<?php

$q = $_GET['q'];
$i=0;			
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
	$i=1;
	echo "<span id='currentMatch'>If you accept an offer and it says you are not in a current match, then the player deleted the offer before you accepted it.</span>";
	echo " <br><br><table><tr><th>Player</th><th>Info</th><th>Date</th><th>Accept</th><th>Decline</th></tr>";
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
	echo "</table>";
}

$result3 = mysql_query("SELECT * FROM offers WHERE open>0 AND playerFrom='" .$q."' ORDER BY dayMade DESC");
if(mysql_num_rows($result3) == 0) {
    
}
else{
	echo "||<br><br><span id='currentMatch'>Offers Made</span><br><br><table><tr><th>Player</th><th>Info</th><th>Date</th><th>Delete</th></tr>";
	while ($row3 = mysql_fetch_array($result3)) {
		//Changes date to just month-day-year
		$phpdate = strtotime( $row3{'dayMade'} );
		$date = date( 'F j', $phpdate );
		$result4 = mysql_query("SELECT firstName,lastName FROM users WHERE id=" .$row3{'playerTo'});
		$row4 = mysql_fetch_array($result4); 
		$name2 = $row4{'firstName'} . " " . $row4{'lastName'};
	 	echo "<tr><td class='normaltd'><a target='_blank' class='td-link' href='otherprofile.html?id=" .$row3{'playerTo'} . "'>" . $name2 . "</a></td><td class='normaltd'>" . $row3{'info'} . "</td><td class='normaltd'>" . $date ."</td>";
	 	echo "<td class='buttontd'><center><button onclick=\"location.href='/api/declineOffer.php?q="  .$row3{'offerID'}. "'\"class='shabu-button signup-button blue td'>Delete</button></center></td></tr>";
	}
	echo "</table>";
}

mysql_close($dbhandle);

?>
