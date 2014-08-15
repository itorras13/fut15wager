<?php

$q = $_GET['q'];
                
$username = "root";
$password = "root";
$hostname = "localhost"; 
$i=0;

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

$checkUserID = mysql_query("SELECT matchID FROM matches WHERE status=0 AND player1 ='" .$q. "'");

if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
if (mysql_num_rows($checkUserID) != 0) {
    echo "delete";
}
else {
	$checkMatches = mysql_query("SELECT matchID,playerRated FROM matches WHERE (status=1 OR status=2) AND (player1=" .$q. " OR player2=" .$q. ")");
    if (mysql_num_rows($checkMatches) != 0) {
    	$i=1;
	}
    else{
        echo "create";
    }
    while ($row = mysql_fetch_array($checkMatches)) {
        if($row{'playerRated'}==$q){
            echo "create";
        }
        else{
            echo $row{'matchID'};
        }
    }
}


mysql_close($dbhandle);

header("Location: /myprofile.html",TRUE,303);

?>