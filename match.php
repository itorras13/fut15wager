<!--<?php
require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
$params = array();
$params["title"] = "Quick chat";
$params["nick"] = "guest".rand(1,1000);  // setup the intitial nickname
$params['firstisadmin'] = true;
//$params["isadmin"] = true; // makes everybody admin: do not use it on production servers ;)
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$params["debug"] = false;
$chat = new phpFreeChat( $params );

?>-->

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>fut15wager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Webflow">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/webflow.css">
    <link rel="stylesheet" type="text/css" href="css/more.css">
    <link rel="stylesheet" type="text/css" href="css/fut15wager.webflow.css">
    <!--<link rel="stylesheet" title="classic" type="text/css" href="/phpfreechat-1.7/style/generic.css" />
    <link rel="stylesheet" title="classic" type="text/css" href="/phpfreechat-1.7/style/header.css" />
    <link rel="stylesheet" title="classic" type="text/css" href="/phpfreechat-1.7/style/footer.css" />
    <link rel="stylesheet" title="classic" type="text/css" href="/phpfreechat-1.7/style/menu.css" />
    <link rel="stylesheet" title="classic" type="text/css" href="/phpfreechat-1.7/style/content.css" />  -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="/javascript/singleMatchScript.js"></script>

</head>

<body>
    <div id="fb-root"></div>

    <header class="navbar">
        <div class="w-container">
            <div class="w-row">
                <div class="w-col w-col-4 w-clearfix">
                    <a href="/index.html">
                        <img class="logo" src="images/fut15.jpg" width="200" alt="53d7cc651c6ecb463cc12bd4_fut15.jpg">
                    </a>
                </div>
                <div class="w-col w-col-8 nav-column">
                    <br>
                    <br>
                    <a class="nav-link" id="inAMatch" href="/match.html"></a>
                    <a class="nav-link" href="/allMatches.html">Matches</a>
                    <a class="nav-link" id="offers" href="/offers.html">Offers</a>
                    <a class="nav-link" href="/myprofile.html">My Profile</a>
                    <a class="nav-link" href="#" onclick="logOut();return false;">Log Out</a>
                </div>
            </div>
        </div>
    </header>
    <div class="section match profile">
        <div class="w-container">
            <div class="w-row">
                <div class="w-col w-col-6 vertical-line">
                    <span id="userInfo">
                    </span>
                    <br><br>
                    <span id='system'>
                    </span>

                </div>
                <div class="w-col w-col-6 right player2Div">

                    <span id="userInfo2">
                    </span>
                    <br><br>
                    <span id='system2'>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-clearfix section" id="features">
        <div class="w-container">
            <div class="w-row">
                <div class="w-col w-col-4">
                    <h3>Click button when game is over</h3>
                </div>
                <div id="buttonArea" class="w-col w-col-3 center">
                     <h3>Match Info</h3>
                </div>
                <div class="w-col w-col-5 right">
                    <h3>Message the player to set a time to play</h3>
                </div>
            </div>
            <div class="w-row">
                <div class="w-col w-col-4">
                    <a class="shabu-button signup-button blue" href="/rate.html" onclick="return confirm('Are you sure the game is over?');". class="shabu-button signup-button blue td">Done</a>
                </div>
                <div class="w-col w-col-3 center">
                    <span id="matchInfo">

                    </span>  
                </div>
                <div class="w-col w-col-5 right">
                    <span id="messageLink">
                        <!--<?php $chat->printChat(); ?>-->
                    </span>
                </div>
            </div>
        </div>
        <div class="w-col w-col-6 center">
        </div>
    </div>
    </div>
    </div>
    <div class="section grey footer">
        <div class="w-container">
            <p class="footer-text">fut15wager copyright – FIFA 15, FIFA 14 and all FIFA assets property of EA&nbsp;Sports.&nbsp;&nbsp;</p>
            <div class="button-block">
                <a class="w-inline-block social-button" href="mailto:itorras13@gmail.com?subject=fut15wager" target="_blank">
                    <img src="images/email-icon.png" width="21px" alt="52af8da2aed63fb91400000f_email-icon.png">
                </a>
                <a class="w-inline-block social-button" href="http://facebook.com/nacho.torras.3" target="_blank">
                    <img src="images/facebook-icon.png" width="21px" alt="52af8da8aed63fb914000010_facebook-icon.png">
                </a>
                <a class="w-inline-block social-button" href="http://twitter.com/nachdacratch" target="_blank">
                    <img src="images/twitter-icon.png" width="21px" alt="52af8db1aed63fb914000011_twitter-icon.png">
                </a>
                <br>
                <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <div class="fb-like" data-href="https://fut15wager.com" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            </div>

            <img class="logo-in-footer" src="images/fut15.jpg" width="300" alt="53d7cc651c6ecb463cc12bd4_fut15.jpg">
        </div>
    </div>
</body>

</html>