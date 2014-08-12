    // This is called with the results from from FB.getLoginStatus().
    var uid;
    var system;
    var offers;

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
        // These three cases are handled in the callback function.

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
        console.log('Welcome!  Fetching your information.... ');
        $.ajax({
            url: "/api/updateOffers.php?q=" + id,
            success: function(result) {
                console.log('Offers updated');
            }
        });
        FB.api('/me', function(response) {
            console.log('Successful login for: ' + response.name);
            document.getElementById('userInfo').innerHTML = '<h1><a class="hero-header" target ="_blank" href="' + response.link + '">' + response.name + '<a/></h1>';
            document.getElementById('facePic').innerHTML = '<img class="hero-iphone" src="https://graph.facebook.com/' + id + '/picture?type=large&height=200&width=200">';
            $(document).ready(function() {
                $.ajax({
                    url: "/api/userInfoAPI.php?q=" + id,
                    dataType: 'json',
                    success: function(result) {
                        system = result.message5;
                        offers = result.message6;
                        document.getElementById('offers').innerHTML = "<span id='nOffers'>(" + offers + ")</span> Offers";
                        document.getElementById('system').innerHTML = result.message1;
                        document.getElementById('thumbsUp').innerHTML = result.message2;
                        document.getElementById('thumbsDown').innerHTML = result.message3;
                        document.getElementById('badSignal').innerHTML = result.message4;
                        document.getElementById("editLink").style.visibility = "visible";
                    }
                });
                $.ajax({
                    url: "/api/checkIfMatch.php?q=" + id,
                    success: function(result) {
                        if (result == 'delete') {
                            document.getElementById('buttonArea').innerHTML = '<a class="shabu-button signup-button blue" href="#" onclick="location.href=\'/api/deleteMatch.php?q=' + uid + '\'"class="shabu-button signup-button blue td">Delete Your Match</a>';
                        } else if (result =='create') {
                            document.getElementById('buttonArea').innerHTML = '<a class="shabu-button signup-button blue" href="#" onclick="showForm();return false;">Create a Match</a>';
                        } else {
                            document.getElementById('buttonArea').innerHTML = '<a class="shabu-button signup-button blue" href="/match.html?id=' + result + '">Go to match</a>';
                        }
                    }
                });
                $.ajax({
                    url: "/api/currentMatchAPI2.php?q=" + uid,
                    dataType: 'json',
                    success: function(result) {
                        if(result.message1==="open"){
                            document.getElementById('profileMatch').innerHTML = result.message2;
                        } else if(result.message1==="none") {
                            document.getElementById('profileMatch').innerHTML = result.message2;
                        } else {
                            document.getElementById('inAMatch').innerHTML = 'Current Match';
                            document.getElementById('inAMatch').href=result.message2; 
                            document.getElementById('profileMatch').innerHTML = 'You are in a match.';
                        }
                    }
                });
            });
        });
    }
    //If not logged in
    function notLoggedIn() {
        window.alert('You are not logged in, you will be directed to the homepage.');
        //redirect them to home page if not logged in
        window.location.assign("/index.html")
    }

    function editProfile(){
        var code = '<form id="createForm"><fieldset>System:<select id="editSystem" name="editSystem" required><option value="Xbox 360">Xbox 360</option>';
            code += '<option value="Xbox One">Xbox One</option><option value="PS4">PS4</option><option value="PS3">PS3</option>';
            code += '<option value="PC">PC</option></select><br>Username:<input type="text" id="username" maxlength="20" required>';
            code += '<br>Email:<input type="text" id="email" maxlength="30" required>';
            code +=  '</fieldset><br><input class="shabu-button signup-button blue small" type="button" id="edit" value="Save"/></form>';
        document.getElementById('system').innerHTML = code;
        $("#edit").click(function() {
            var editSystem = $("#editSystem").val();
            var username = $("#username").val();
            var email = $("#email").val();

            if (editSystem == '' || username == '' || uid == '' || email=='') {
                alert("Insertion Failed Some Fields are Blank....!!");
            } else {
                // Returns successful data submission message when the entered information is stored in database.
                $.post("/api/editProfile.php", {
                        username1: username,
                        editSystem1: editSystem,
                        uid1: uid,
                        email1: email,
                    },
                    function(data) {
                        alert(data);
                        $('#createForm')[0].reset(); //To reset form fields
                        window.location.assign("/myprofile.html")
                    });

            }
        });
    }

    //Submits match
    $(document).ready(function() {

        $("#submit").click(function() {
            var title = $("#title").val();
            var info = $("#info").val();

            if (title == '' || info == '' || uid == '' || system == '') {
                alert("Insertion Failed Some Fields are Blank....!!");
            } else {
                // Returns successful data submission message when the entered information is stored in database.
                $.post("/api/insertMatch.php", {
                        title1: title,
                        info1: info,
                        uid1: uid,
                        system1: system,
                    },
                    function(data) {
                        alert(data);
                        $('#createForm')[0].reset(); //To reset form fields
                        document.getElementById("createForm").style.visibility = "hidden";
                        window.location.assign("/myprofile.html")
                    });

            }
        });
        
    });

    function showForm() {
        document.getElementById("createForm").style.visibility = "visible";
    }



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