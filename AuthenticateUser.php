<?php namespace Grohman\Socialite;

use Exception;
use Grohman\Socialite\Models\Provider;
use Laravel\Socialite\Contracts\Factory as Socialite;
use October\Rain\Foundation\Application as OctoApp;
use RainLab\User\Facades\Auth as Authenticator;

class AuthenticateUser
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Authenticator
     */
    private $auth;

    /**
     * @param UserRepository $users
     * @param Socialite      $socialite
     * @param Authenticator  $auth
     */
    public function __construct(UserRepository $users, Socialite $socialite, Authenticator $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth->getFacadeRoot();
    }

    /**
     * @param boolean                  $hasCode
     * @param AuthenticateUserListener $listener
     * @param                          $provider
     * @param                          $callbackUrl
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws Exception
     * @throws \October\Rain\Auth\AuthException
     */
    public function execute($hasCode, AuthenticateUserListener $listener, $provider, $callbackUrl)
    {
        $this->setProviderConfig($provider, $callbackUrl);

        if (!$hasCode) {
            return $this->getAuthorizationFirst($provider);
        }

        $user = $this->users->findByUserdataOrCreate($this->getUserData($provider), $provider);

        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    public function setProviderConfig($provider, $callbackUrl)
    {
        $result = Provider::whereClientName($provider)->first();
        if ($result) {
            config()->set('services.' . $provider, [
                'client_id' => $result->client_id,
                'client_secret' => $result->client_secret,
                'redirect' => $callbackUrl,
                'provider_id' => $result->id
            ]);

            $providerFullClassName = 'SocialiteProviders\\' . $provider . '\\Provider';
            if (class_exists($providerFullClassName)) {
                $socialite = app()->make('Laravel\Socialite\Contracts\Factory');
                $socialite->extend($provider, function (OctoApp $app) use ($providerFullClassName, $provider, $socialite) {
                    return $socialite->buildProvider($providerFullClassName, config()->get('services.' . $provider));
                });
            }

            return true;
        }
        throw new Exception('Provider ' . $provider . ' config undefined');
    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider)
    {
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Laravel\Socialite\Contracts\User
     * @throws Exception
     */
    private function getUserData($provider)
    {
        try {
            return $this->socialite->driver($provider)->user();
        } catch(Exception $e) {
            throw new Exception('Auth failed');
        }
    }
}