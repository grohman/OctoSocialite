<?php namespace Grohman\Socialite;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller implements AuthenticateUserListener
{

    /**
     * @param Illuminate\Http\Request|Request $request
     * @param AuthenticateUser                $authenticateUser
     * @param                                 $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request, AuthenticateUser $authenticateUser, $provider)
    {
        $hasCode = $request->has('code');
        return $authenticateUser->execute($hasCode, $this, $provider, $request->url());
    }

    /**
     * When a user has successfully been logged in...
     *
     * @param $user
     * @return \Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user)
    {
        return redirect('/login');
    }

}