<?php


Route::get('/', function()
{
	$login = Facebook::getLoginUrl(['email', 'user_likes', 'user_posts'], 'https://badgify.rmob.is/facebook/login/');

	return '<a href="' . $login . '">Log in with Facebook!</a>';
});

//Route::post('/', function()
//{
//	$jsHelper = Facebook::getJavaScriptHelper();
//
//	dd($jsHelper);
////	$permissions = ['email', 'user_likes']; // optional
////	$loginUrl = $helper->getLoginUrl('https://{your-website}/login-callback.php', $permissions);
////
////	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
//
//	// return View::make('login');
//});

Route::post('/', function()
{
	$login = Facebook::getLoginUrl(['email', 'user_likes', 'user_posts'], 'https://badgify.rmob.is/facebook/login/');

	return '<a href="' . $login . '">Log in with Facebook!</a>';

//	$helper = Facebook::getLoginUrl();
//	$permissions = ['email', 'user_likes', 'user_posts']; // optional
//	$loginUrl = $helper->getLoginUrl('https://{your-website}/login-callback.php', $permissions);
//
//	dd($loginUrl);

    //return Redirect::to(Facebook::getLoginUrl());
});

Route::get('/facebook/login', function()
{
	dd(Input::all());
    try
    {
        $token = Facebook::getTokenFromRedirect();

        if (!$token)
        {
            return "Error obtaining token!";
        }
    }
    catch (FacebookQueryBuilderException $e)
    {
        // Facebook query builder error!
        return $e->getPrevious()->getMessage();
    }


    // If the token is short lived, we'll extend it
    // Ref: https://developers.facebook.com/docs/facebook-login/access-tokens#extending
    if (!$token->isLongLived())
    {
        try
        {
            $token = $token->extend();
        }
        catch (FacebookQueryBuilderException $e)
        {
            return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
        }
    }

    // Setting the access token
    Facebook::setAccessToken($token);
    Session::put('facebook_access_token', (string) $token);

    // Getting some basic user info
    try
    {
        $facebook_user = Facebook::object('me')->fields('id','name')->get();
    }
    catch (FacebookQueryBuilderException $e)
    {
        return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
    }

//    $user = User::createOrUpdateFacebookObject($facebook_user);

//    Facebook::auth()->login($user);

    return Redirect::to("/posts/10");
});

Route::get('/posts/{count}', function($count)
{
    $token = Session::get('facebook_access_token');
    Facebook::setAccessToken($token);

	try {
		$posts = Facebook::object('me/feed')->with(['with' => 'location',
		'limit' => $count])->get();
	} catch (\SammyK\FacebookQueryBuilder\FacebookQueryBuilderException $e) {
		dd($e->getPrevious()->getMessage());
	}

	foreach ($posts as $post)
	{
		if ($post->has('message'))
		{
			print $post['message'].'<br>';
			$place = Facebook::object($post['place']['id'])->get();
			print $post['place']['name'].' - '.$place['category'];
			print "<br>";
		}
	}

});
