@extends('gen.base')
@section('title', 'Complete Profile')

@section('content')
    <script>

        /////facebook sign in
        function fb_login() {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    FB.api('/me', {fields: 'id,first_name,last_name,email,gender'}, function(response) {
                        document.getElementById('email').setAttribute('value', response.email);
                        document.getElementById('name').setAttribute('value', response.first_name + ' ' + response.last_name);
                        document.getElementById('photo').style.backgroundImage = "url(http://graph.facebook.com/"+ response.id + "/picture?type=large)";
                        document.getElementById('image').setAttribute('value', "http://graph.facebook.com/"+ response.id + "/picture?type=large");
                    });
                } else {
                    // The person is not logged into this app or we are unable to tell.
                }
            }, { scope: 'public_profile,email' });
        }
        function fb_logout() {
            FB.logout(function(response) {
                // Person is now logged out
                alert('logged out');
            });
        }
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1798027780490122',
                xfbml      : true,
                version    : 'v2.10'
            });
            FB.AppEvents.logPageView();
        };
        // Load the SDK asynchronously
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        //////////////////////////end of facebook signin

        /////google sign in
        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function(){
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: '882141415488-qqaij3ruu8jkgptgpgl75799hbkpf3tr.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin'
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                attachSignin(document.getElementById('customBtn'));
            });
        };

        function attachSignin(element) {
            auth2.attachClickHandler(element, {},
                    function(googleUser) {
                        var responsee = {
                            "first_name": googleUser.getBasicProfile().getGivenName(),
                            "last_name": googleUser.getBasicProfile().getFamilyName(),
                            "email": googleUser.getBasicProfile().getEmail(),
                            "picture": googleUser.getBasicProfile().getImageUrl()
                        };
                        document.getElementById('email').setAttribute('value', responsee.email);
                        document.getElementById('name').setAttribute('value', responsee.first_name + ' ' + responsee.last_name);
                        document.getElementById('photo').style.backgroundImage = "url("+responsee.picture+")";
                        document.getElementById('image').setAttribute('value', responsee.picture);
                    }, function(error) {
                    });
        }
        ////////////////end of google sign in
    </script>
    @include('gen/header')
    <div class="container">
        <div class="row verify-top">
            <div class="col-md-8 ml-auto mr-auto text-center">
                <h2 class="title"> Profile.</h2>
                <h5 class="description">Complete your profile information.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6 ">
                        <button id="signup_fb" href="" title="Facebook" class="btn btn-block btn-social btn-lg btn-facebook zero-margin-bottom-mobile" onclick="fb_login()">
                            <i class="fa fa-facebook"></i> Complete using Facebook
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button id="customBtn" class="btn btn-block btn-social btn-lg btn-google small-top-margin-mobile">
                            <i class="fa fa-google"></i> Complete using Google
                        </button>
                    </div>
                </div>
                <hr/>
                <p class="divider">OR</p>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="no-top-margin">
                    <div class="">
                        <form method="POST" action="{{ site_url(). 'signup/profile' }}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="First-Name Last-Name">
                                    </div>
                                    <div class="input-group">
                                        <input type="email" id="email" name="email" required class="form-control small-top-margin-mobile" placeholder="Email Address">
                                    </div>
                                    <div id="photo" class="profile-img small-top-margin-mobile" style="background-image: url({{ base_url(). 'img/user.png' }})"></div>
                                    <input type="hidden" id="image" name="image">
                                    <button type="submit" class="btn btn-info btn-round btn-block small-top-margin-mobile">Submit Profile Information</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>startApp();</script>
@endsection