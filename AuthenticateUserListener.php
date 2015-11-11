<?php namespace Grohman\Socialite;


interface AuthenticateUserListener
{

    /**
     * @param $user
     * @return mixed
     */
    public function userHasLoggedIn($user);

}