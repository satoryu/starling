<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwitterAccountService;

use Socialite;

class LoginController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback(TwitterAccountService $accountService)
    {
        $user = Socialite::driver('twitter')->user();

        $authUser = $accountService->findOrCreateUser($user);

        auth()->login($authUser, true);

        return view('test');
    }

    public function logout()
    {
        return redirect(route('apps.index'));
    }
}
