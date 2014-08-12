<?php

$player1ID = $_GET['q'];
$player2ID = $_GET['q2'];
$offerId = $_GET['offerId'];
$match = $_GET['match'];
				
$username = "root";
$password = "root";
$hostname = "localhost"; 

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

$result = mysql_query("SELECT info FROM offers WHERE open>0 AND matchNumber=" .$match);
while ($row = mysql_fetch_array($result)) {
	$info = $row{'info'};
}


mysql_query("UPDATE offers SET open=0 WHERE matchNumber=" .$match);
mysql_query("UPDATE matches SET status=1,player2=" .$player2ID. ",offerTaken='" .$info. "' WHERE matchID=" .$match);
mysql_query("UPDATE matches SET status=4 WHERE player1=" .$player2ID);

$result2 = mysql_query("SELECT email FROM users WHERE id=" .$player2ID);
while ($row2 = mysql_fetch_array($result2)) {
	$email = $row2{'email'};
}
$result3 = mysql_query("SELECT info,title,offerTaken FROM matches WHERE matchID=" .$match);
while ($row3 = mysql_fetch_array($result3)) {
	$info2 = $row3{'info'};
	$title = $row3{'title'};
	$message = $row3{'offerTaken'};
}

$mailer = Swift_Mailer::newInstance($transporter);
  $message = Swift_Message::newInstance('Fut 15 Wager')
  ->setFrom('itorras13@gmail.com')
  ->setTo($email)
  ->setBody('<html><head></head><body>Your offer has been accepted.<br><br>For Match<br>Title: ' .$title. '<br>Info: ' .$info2. '<br>' .
    '<br>OfferTaken<br>Message: ' .$message. '<br><br><a href="http://localhost:8888/myprofile.html">Go to your Profile</a></body></html>',
    'text/html');
$result = $mailer->send($message);

mysql_close($dbhandle);

header("Location: /offers.html",TRUE,303);

?>