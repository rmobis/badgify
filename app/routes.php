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
    $token = Facebook::getTokenFromRedirect();
    return $token;
});
