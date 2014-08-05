<?php

				
$username = "root";
$password = "root";
$hostname = "localhost"; 

$title=$_POST['title1'];
$info=$_POST['info1'];
$system=$_POST['system1'];
$uid=$_POST['uid1'];

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

date_default_timezone_set('America/Monterrey');
$date = date('Y-m-d H:i:s ', time());

$checkMatches = mysql_query("SELECT matchID FROM matches WHERE status=1 AND (player1=" .$uid. " OR player2=" .$uid. ")");
if (mysql_num_rows($checkMatches) != 0) {
    $i=1;
}

$checkUserID = mysql_query("SELECT matchID FROM matches WHERE status=0 AND player1 ='" .$q. "'");

if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
if($i==1){
	echo "You cannot create a game if you are currently in one.";
}
else if (mysql_num_rows($checkUserID) != 0) {
    echo "You can only have one match open at a time.";
}
else if($sytem='null'){
  echo "Please insert your gamertag and system in your profile before doing anything else!";
}
else {
    mysql_query("INSERT INTO matches (title,info,dayMade,player1,system,status)
	VALUES('$title','$info', '$date','$uid','$system',0)") or die(mysql_error());  
	echo "Your match has been created.";
}


mysql_close($dbhandle);

?>