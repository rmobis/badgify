<?php

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Input;

Route::get('/', function()
{
	return View::make('hello');
});

Route::post('/', function()
{
	return dd(Input::all());
});

Route::get('/login', function()
{
    return Redirect::to(Facebook::getLoginUrl()); 
});

Route::get('/facebook/login', function()
{
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
