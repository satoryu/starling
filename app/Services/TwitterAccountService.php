<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Socialite\Contracts\User as ProviderUser;

use App\TwitterAccount;
use App\User;

class TwitterAccountService
{
    public function findOrCreateUser(ProviderUser $providerUser)
    {
        $user = User::firstOrCreate(
            [ 'twitter_id' => $providerUser->getId() ],
            [ 'name' => $providerUser->getName() ]
        );

        $user->twitterAccount()->updateOrCreate([
            'screen_name' => $providerUser->nickname,
            'profile_image_url' => $providerUser->avatar,
            'token' => $providerUser->token,
            'token_secret' => $providerUser->tokenSecret
        ]);

        return $user;
    }
}