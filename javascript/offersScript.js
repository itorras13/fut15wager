    // This is called with the results from from FB.getLoginStatus().
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

    
    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function loggedIn(id) {
        $.ajax({
            url: "/api/currentMatchAPI2.php?q=" + id,
            dataType: 'json',
            success: function(result) {
                if(result.message1==="open"){
                     document.getElementById('currentMatch').innerHTML = result.message2;
                } else if(result.message1==="none") {
                     document.getElementById('currentMatch').innerHTML = result.message2;
                } else {
                    document.getElementById('inAMatch').innerHTML = 'Current Match';
                    document.getElementById('inAMatch').href=result.message2; 
                    document.getElementById('currentMatch').innerHTML = "You are in a match";
                }
            }
        });
        $.ajax({
            url: "/api/updateOffers.php?q=" + id,
            success: function(result) {
                console.log('Offers updated');
            }
        });
        $.ajax({
            url: "/api/actualOffersAPI.php?q=" + id,
            //dataType: 'json',
            success: function(result) {
                if(result=='none'){
                    document.getElementById('currentMatch').innerHTML = "";
                     $("#table").append("<span class='nOffers'>You have no offers.</span>");
                }
                else{
                    $("#table").append(result);
                }
            }
        });
        $.ajax({
            url: "/api/offersAPI.php?q=" + id,
            dataType: 'json',
            success: function(result) {
                offers = result;
                document.getElementById('offers').innerHTML = "<span id='nOffers'>(" + offers + ")</span> Offers";
            }
        });
    }
    //If not logged in
    function notLoggedIn() {
        window.alert('You are not logged in, you will be directed to the homepage.');
        //redirect them to home page if not logged in
        window.location.assign("/index.html");
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