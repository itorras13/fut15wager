<?php


				
$username = "root";
$password = "root";
$hostname = "localhost"; 

$rater=$_POST['rater1'];
$rating=$_POST['rating1'];
$thumbs=$_POST['thumbs1'];
$signal=$_POST['signal1'];
$id=$_POST['matchId1'];
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

$result = mysql_query("SELECT playerRated,status FROM matches WHERE matchID=" .$id);

while ($row = mysql_fetch_array($result)) {

$playerRated=$row{'playerRated'};
$status =$row{'status'};

	if($rater!=$playerRated && $status!=4){
		if($status==2){
			mysql_query("UPDATE matches SET status=status+2 WHERE matchID=" .$id);
		}
		else if($status==1){
			mysql_query("UPDATE matches SET status=status+1,playerRated=" .$rater. " WHERE matchID=" .$id);
		}
		if($thumbs=="Up"){
			mysql_query("UPDATE users SET thumbsUp=thumbsUp+1 WHERE id=" .$rating);
			if($status==1){
				mysql_query("UPDATE matches SET ratedUp=1 WHERE matchID=" .$id);
			}
			else{
				mysql_query("UPDATE matches SET ratedUp2=1 WHERE matchID=" .$id);
			}
		}
		else{
			mysql_query("UPDATE users SET thumbsDown=thumbsDown+1 WHERE id=" .$rating);
			if($status==1){
				mysql_query("UPDATE matches SET ratedDown=1 WHERE matchID=" .$id);
			}
			else{
				mysql_query("UPDATE matches SET ratedDown2=1 WHERE matchID=" .$id);
			}
		}

		if($signal=="Bad"){
			mysql_query("UPDATE users SET badSignal=badSignal+1 WHERE id=" .$rating);
			if($status==1){
				mysql_query("UPDATE matches SET ratedBad=1 WHERE matchID=" .$id);
			}
			else{
				mysql_query("UPDATE matches SET ratedBad2=1 WHERE matchID=" .$id);
			}
		}
		echo "Your rating has been submitted.";
	}
	else{
		echo "You had already rated for this game.";
	}
}



mysql_close($dbhandle);

?>