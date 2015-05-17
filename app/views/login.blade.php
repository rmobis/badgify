@extends('base')

@section('additional')
    function onLogin(response) {
      if (response.status == 'connected') {
        top.location = "https://badgify.rmob.is/posts/10";

      }
    }

    FB.getLoginStatus(function(response) {
      // Check login status on load, and if the user is
      // already logged in, go directly to the welcome message.
      if (response.status == 'connected') {
        onLogin(response);
      } else {
        // Otherwise, show Login dialog first.
        FB.login(function(response) {
          onLogin(response);
        }, {scope: 'user_friends, email', 'user_posts'});
      }
    });
@stop
@section('content')
    <h1 id="fb-welcome">Logging in...</h1>

@stop