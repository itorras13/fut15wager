<?php

$q = $_GET['q'];
$con = mysql_connect('localhost','root','root');

if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

mysql_select_db($con,'fut')or die("cannot select DB");
					

					
$strSQL= "SELECT * FROM users";

					
if($rs=mysqli_query($con,$strSQL)){
	while($row=mysqli_fetch_array($rs)) {
		echo "<p>" . $rs['firstName'] . " " . $rs['lastName'] . "</p>";
	}
}
else {
	die(mysqli_error($con));
}

mysqli_close($con);
?>