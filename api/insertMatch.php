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

mysql_query("INSERT INTO matches (title,info,dayMade,player1,system,status)
VALUES('$title','$info', '$date','$uid','$system',0)") or die(mysql_error());  ;

mysql_close($dbhandle);

?>