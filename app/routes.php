<?php

Route::get('/', function()
{
	return View::make('hello');
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

    // Getting some basic user info
    $user = User::createOrUpdateFacebookObject($facebook_user);

    Facebook::auth()->login($user);

    return $token;
});
