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
$result = mysql_query("SELECT dayMade,title,player1,matchID FROM matches WHERE status=0 AND player1!=" .$q. " AND system='" .$system."' ORDER BY dayMade DESC");
//fetch tha data from the database
if($system==null){
	echo "<span class='nOffers'>No matches will be shown until you enter what sytem you have in your profile.</span>";
}
else if(mysql_num_rows($result) == 0) {
    echo "<span class='nOffers'>There are currently no matches open for " .$system. ".</span>";
}
else{
	echo "<span class='nOffers'>Matches shown for: " .$system. ".</span>";

	echo "<br><br><table><tr><th>Title</th><th>Player</th><th>Date</th></tr>";
	while ($row = mysql_fetch_array($result)) {
		//Changes date to just month-day-year
		$phpdate = strtotime( $row{'dayMade'} );
		$date = date( 'F j', $phpdate );
		$result2 = mysql_query("SELECT firstName,lastName FROM users WHERE id=" .$row{'player1'});
		$row2 = mysql_fetch_array($result2); 
		$name = $row2{'firstName'} . " " . $row2{'lastName'};
	 	echo "<tr><td class='normaltd'><a class='td-link match' href='otherprofile.html?id=" .$row{'player1'} . "'>" . $row{'title'};
	 	echo "</a></td><td class='normaltd'><a target='_blank' class='td-link match' href='otherprofile.html?id=" .$row{'player1'} . "'>";
	 	echo $name . "</a></td><td class='normaltd'>" . $date ."</td></tr>";
	}
	echo "</table>";
}

mysql_close($dbhandle);

?>