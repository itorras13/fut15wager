// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response, i) {
    console.log('statusChangeCallback');
    console.log(response);
    console.log(i);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        uid = response.authResponse.userID;
        if (i == 1) {

            justLoggedIn(uid);
        }
        loggedIn(uid);
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = '  Please log ' +
            'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = '  Please log ' +
            'into Facebook.';
    }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response, 1);
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

    FB.getLoginStatus(function(response) {
        statusChangeCallback(response, 0);
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

function justLoggedIn(uid) {
    FB.api('/me', function(response) {
        $.ajax({
            url: "/api/insertUser.php?id=" + uid + "&first=" + response.first_name + "&last=" + response.last_name,
            success: function(result) {
                if (result == 'new') {
                    alert('Thank you for joining. You will be redirected to your profile page');
                    window.location.assign("/myprofile.html");
                } else {
                    alert('Welcome Back! You will be redirected to your profile page');
                    window.location.assign("/myprofile.html");
                }
            }
        });
    });
}

function loggedIn(uid) {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        document.getElementById('loginButton').innerHTML =
            '<a href="/myprofile.html">' + response.name + '</a>' + ' is logged in!';
    });
}