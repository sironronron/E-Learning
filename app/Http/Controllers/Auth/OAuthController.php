<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OAuthProvider;
use App\Http\Controllers\Controller;
use App\Exceptions\EmailTakenException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// Notify user 
use Notification;
use App\Notifications\UserLoggedIn;

use Illuminate\Support\Carbon;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        config([
            'services.github.redirect' => route('oauth.callback', 'github'),
            'services.facebook.redirect' => route('oauth.callback', 'facebook'),
            'services.google.redirect' => route('oauth.callback', 'google')
        ]);
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return [
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ];
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $user);

        $this->guard()->setToken(
            $token = $this->guard()->login($user)
        );

        return view('oauth/callback', [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User|false
     */
    protected function findOrCreateUser($provider, $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {

            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);

            $getUserLoggedIn = User::where('id', $oauthProvider->user_id)
            ->first();

            // Notify user of new logged In
            $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
            $appUrl = config('app.client_url', config('app.url'));
            $appName = config('app.name');

            if ($getUserLoggedIn->last_login_ip != $ip || $getUserLoggedIn->last_login_ip == null) {
                $details = [
                    'subject' => "New Login to $appName",
                    'greeting' => "We noticed a login to your account $getUserLoggedIn->email from a different IP. Was this you?",
                    'you' => "If this was you",
                    'ignore' => "You can ignore this message. There's no need to take any action.",
                    'notYou' => "If this wasn't you",
                    'respond' => "Click the button below to change your password",
                    'actionText' => 'Reset Password',
                    'actionURL' => url("$appUrl" . "/password/reset")
                ];
                Notification::send($getUserLoggedIn, new UserLoggedIn($details));
            }

            $getUserLoggedIn->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $ip         
            ]);

            return $oauthProvider->user;
        }

        if (User::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User
     */
    protected function createUser($provider, $sUser)
    {
        $user = User::create([
            'avatar' => $sUser->getAvatar(),
            'name' => $sUser->getName(),
            'username' => str_slug($sUser->getName(), '-'),
            'email' => $sUser->getEmail(),
            'email_verified_at' => now(),
            'role_id' => 2
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }
}
