<?php

				
$username = "root";
$password = "root";
$hostname = "localhost"; 

$playerTo=$_POST['qParam1'];
$message=$_POST['message1'];
$playerFrom=$_POST['uid1'];
$i=0;

//email stuff
require_once '../swiftmailer/lib/swift_required.php';
$transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('itorras13@gmail.com')
  ->setPassword('lolisfunny')
;


//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("fut",$dbhandle) 
  or die("Could not select examples");

date_default_timezone_set('America/Monterrey');
$date = date('Y-m-d H:i:s ', time());


$checkUserID = mysql_query("SELECT matchID,title,info FROM matches WHERE status=0 AND player1 ='" .$playerTo. "'");
if (!$checkUserID) {
    die('Query failed to execute for some reason');
}
while ($row = mysql_fetch_array($checkUserID)) {
	$matchID = $row{'matchID'};
  $title = $row{'title'};
  $info = $row{'info'};
}

$checkMatches = mysql_query("SELECT matchID FROM matches WHERE status=1 AND (player1=" .$playerFrom. " OR player2=" .$playerFrom. ")");
if (mysql_num_rows($checkMatches) != 0) {
    $i=1;
}
$checkOffers = mysql_query("SELECT matchNumber FROM offers WHERE open=1 AND playerTo =" .$playerTo. " AND playerFrom=" .$playerFrom);

if($i==1){
	echo "You cannot make an offer if you are currently in a game.";
}
elseif (mysql_num_rows($checkOffers) != 0) {
    echo "You can only make one offer to the same player at a time.";
}
else {
    mysql_query("INSERT INTO offers (matchNumber,info,dayMade,playerTo,playerFrom,open)
	VALUES('$matchID','$message','$date','$playerTo','$playerFrom',1)") or die(mysql_error());  
	echo "Your offer has been sent.";
  //Send emails
  $getEmail = mysql_query("SELECT email FROM users WHERE id =" .$playerTo);
  while ($row = mysql_fetch_array($getEmail)) {
    $email = $row{'email'};
  }
  $mailer = Swift_Mailer::newInstance($transporter);
  $message = Swift_Message::newInstance('Fut 15 Wager')
  ->setFrom('itorras13@gmail.com')
  ->setTo($email)
  ->setBody('<html><head></head><body>You have been sent an offer.<br>Your match<br>Title: ' .$title. '<br>Info: ' .$info. '<br>' .
    '<br>OfferTaken<br>Message: ' .$message. '<br><br><a href="http://localhost:8888/myprofile.html">Go to your Profile</a></body></html>',
    'text/html');
  $result = $mailer->send($message);

}


mysql_close($dbhandle);

?>