<?php

use Carbon\Carbon;

Route::get('/', function() {
    if (!Auth::user()) {
        return Redirect::to('/login');
    }

	return View::make('home');
});

Route::get('/login', function() {
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
    try
    {
        $facebook_user = Facebook::object('me')->fields('id','name')->get();
    }
    catch (FacebookQueryBuilderException $e)
    {
        return Redirect::to('/')->with('error', $e->getPrevious()->getMessage());
    }

    $user = User::createOrUpdateFacebookObject($facebook_user);

    Facebook::auth()->login($user);
    $user = Auth::user();
    $user->access_token = $token;
    $user->save();

    return Redirect::to('/posts/10');
});

Route::get('/posts/{count}', function($count) {
    $user = Auth::user();
    Facebook::setAccessToken($user->access_token);

	try {
		$posts = Facebook::object('me/feed')->with([/*'with' => 'location',*/
		'limit' => $count])->get();
	} catch (\SammyK\FacebookQueryBuilder\FacebookQueryBuilderException $e) {
		dd($e->getPrevious()->getMessage());
	}

    $achievsDone = $user->achievements()->wherePivot('done', true)->get();
    $achievsNotDone = Achievement::whereNotIn('id', $achievsDone->lists('id'))->get();

    foreach ($achievsNotDone as $achiev) {
        foreach ($posts as $post) {
            if ($post->has('message')) {
                if ($achiev->validateGraphObject($post)) {
                    $piv = $achiev->users()->where('users.id', $user->id)->first();

                    if ($piv === null) {
                        $user->achievements()->attach($achiev->id, [
                            'done' => ($achiev->amount == 1),
                            'achieved_at' => Carbon::now(),
                            'amount' => 1
                        ]);

                        $user->save();
                    } else {
                        $piv->pivot->amount += 1;

                        if ($piv->pivot->amount >= $achiev->amount) {
                            $piv->pivot->done = true;
                            $piv->pivot->achieved_at = Carbon::now();
                        }

                        $piv->save();
                    }
                }
            }
		}
	}

    $badgesDone = $user->badges()->get()->lists('id');
    $badgesNotDone = Badge::whereNotIn('id', $badgesDone)->with('achievements')->get();
    $achievsDone = $user->achievements()->wherePivot('done', true)->get()->lists('id');

    foreach ($badgesNotDone as $badge) {
        $completed = true;
        foreach ($badge->achievements as $achiev) {
            if (! in_array($achiev->id, $achievsDone)) {
                $completed = false;
                break;
            }
        }

        if ($completed) {
            $user->badges()->attach($badge->id, [
                'achieved_at' => Carbon::now()
            ]);
        }
    }

    $user->touch();

    return Redirect::to('/');
});

Route::get('api/user/achievements', function () {
    return Auth::user()
        ->achievements()
        ->withPivot('achieved_at')
        ->wherePivot('done', true)
        ->get()
        ->map(function ($v) {
            return [
                'id' => $v->id,
                'achieved_at' => $v->pivot->achieved_at
            ];
        });
});

Route::get('api/user/badges', function () {
    return Auth::user()
        ->badges()
        ->withPivot('achieved_at')
        ->get()
        ->map(function ($v) {
            return [
                'id' => $v->id,
                'achieved_at' => $v->pivot->achieved_at
            ];
        });
});

Route::get('api/data', function () {
    return Category::with(['badges', 'badges.achievements'])->get();
});
