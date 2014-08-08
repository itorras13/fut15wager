    // This is called with the results from from FB.getLoginStatus().
    var qParam;
    var uid;
    var player2;
    var player1;
    var title;
    var info;

    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            id = response.authResponse.userID;
            uid = response.authResponse.userID;
            if (qParam === "") {
                window.location.assign("/myprofile.html");
            }
            if (uid != player1 && uid != player2) {
                alert('You are not part of this game');
                window.location.assign("/myprofile.html");
            }
            loggedIn(id);
        } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            notLoggedIn();
        } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            notLoggedIn();
        }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId: '1500132366870098',
            status: true,
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true,
            version: 'v2.0'
        });
        // Now that we've initialized the JavaScript SDK, we call 
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function
        qParam = getParameterByName('id');

        $.ajax({
            url: "/api/matchInfoAPI.php?q=" + qParam,
            dataType: 'json',
            success: function(result) {
                player2 = result.message1;
                info = result.message3;
                title = result.message2;
                player1 = result.message4;
                offerTaken = result.message5;
                document.getElementById('rateButton').href = "/rate.html?id=" + qParam;
            }
        });

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(window.location.href);
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function loggedIn(id) {
        document.getElementById('matchInfo').innerHTML = "Title: " + title + "<br>Info: " + info + "<br>Offer Taken: " + offerTaken;
        $.ajax({
            url: "/api/currentMatchAPI2.php?q=" + id,
            dataType: 'json',
            success: function(result) {
                if (result.message1 === "open") {} else if (result.message1 === "none") {} else {
                    document.getElementById('inAMatch').innerHTML = 'Current Match';
                    document.getElementById('inAMatch').href = result.message2;
                }
            }
        });
        $.ajax({
            url: "/api/userInfoAPI.php?q=" + id,
            dataType: 'json',
            success: function(result) {
                document.getElementById('system').innerHTML = result.message1;
                document.getElementById('userInfo').innerHTML = '<h1><a class="hero-header" target ="_blank" href="/myprofile.html">' + result.message7 + '<a/></h1>';
            }
        });
        if (player2 === uid) {
            $.ajax({
                url: "/api/userInfoAPI.php?q=" + player1,
                dataType: 'json',
                success: function(result) {
                    document.getElementById('system2').innerHTML = result.message1;
                    document.getElementById('userInfo2').innerHTML = '<h1><a class="hero-header player2" target ="_blank" href="/otherprofile.html?id=' + player1 + '">' + result.message7 + '<a/></h1>';
                }
            });
            FB.api('/'+player1, function(response) {
                document.getElementById('messageLink').innerHTML = '<a class="nav-link" target ="_blank" href="' + response.link + '">Message' + response.name + '</a>';
            });
        } else if (player1 === uid) {
            $.ajax({
                url: "/api/userInfoAPI.php?q=" + player2,
                dataType: 'json',
                success: function(result) {
                    document.getElementById('system2').innerHTML = result.message1;
                    document.getElementById('userInfo2').innerHTML = '<h1><a class="hero-header player2" target ="_blank" href="/otherprofile.html?id=' + player2 + '">' + result.message7 + '<a/></h1>';
                }
            });
            FB.api('/'+player2, function(response) {
                document.getElementById('messageLink').innerHTML = '<a class="nav-link" target ="_blank" href="' + response.link + '">Message ' + response.name + '</a>';
            });
        }
    }
    //If not logged in
    function notLoggedIn() {
        window.alert('You are not logged in, you will be directed to the homepage.');
        //redirect them to home page if not logged in
        window.location.assign("/index.html");
    }

    //Submits offer
    // $(document).ready(function(){

    //     $("#submit").click(function(){
    //         var message = $("#message").val();

    //         if( message==''|| uid==''|| qParam==''){
    //             alert("Insertion Failed Some Fields are Blank....!!");
    //         }
    //         else{
    //             // Returns successful data submission message when the entered information is stored in database.
    //             $.post("/api/insertOffer.php",{ qParam1: qParam, message1: message, uid1: uid},
    //                  function(data) {
    //                  alert(data);
    //                  $('#createForm')[0].reset(); //To reset form fields
    //                  document.getElementById("createForm").style.visibility="hidden";
    //                  window.location.assign("/myprofile.html")
    //             });

    //         }
    //     });
    // });


    function textCounter(field, field2, maxlimit) {
        var countfield = document.getElementById(field2);
        if (field.value.length > maxlimit) {
            field.value = field.value.substring(0, maxlimit);
            return false;
        } else {
            countfield.innerHTML = "  " + maxlimit - field.value.length + " characters left...";
        }
    }

    function logOut() {
        FB.getLoginStatus(function(ret) {
            /// are they currently logged into Facebook?
            if (ret.authResponse) {
                //they were authed so do the logout
                FB.logout(function(response) {
                    alert('You have been logged out');
                    window.location.assign("/index.html");
                });
            } else {
                alert('You are not logged in');
                //or just get rid of this if you don't need to do something if they weren't logged in
            }
        });
    }