<?php namespace Grohman\Socialite;

use Carbon\Carbon;
use Exception;
use Grohman\Socialite\Models\Token;
use RainLab\User\Models\User;

class UserRepository
{

    /**
     * @param      $userData
     * @param      $provider
     * @return static
     * @throws Exception
     */
    public function findByUserdataOrCreate($userData, $provider)
    {

        $providerId = config()->get("services.$provider.provider_id");
        $tokenExists = $this->findUserBySocialId($providerId, $userData->id);
        if ($tokenExists) {
            return User::find($tokenExists->user_id);
        }

        if ($userData->email == null) {
            throw new Exception('Auth failed, email undefined');
        }

        $userExists = User::whereEmail($userData->email)->first();
        if ($userExists) {
            $this->createSocialToken($providerId, $userExists->id, $userData->id, $userData->token);

            return $userExists;
        }
        $password = str_random(8);
        config()->set('services.socialite.current_password', $password);
        $username = [
            'name' => $userData->name,
            'surname' => null,
        ];
        if(isset($userData->user['first_name']) && isset($userData->user['last_name'])) {
            $username['name'] = $userData->user['first_name'];
            $username['surname'] = $userData->user['last_name'];
        }

        $user = User::create([
            'name' => $username['name'],
            'surname' => $username['surname'],
            'email' => $userData->email,
            'username' => $userData->email,
            'password' => $password,
            'password_confirmation' => $password,
            //'avatar'   => $userData->avatar
        ]);
        $user->activation_code = null;
        $user->activated_at = Carbon::now();
        $user->is_activated = true;
        $user->forceSave();

        $this->createSocialToken($providerId, $user->id, $userData->id, $userData->token);

        return $user;
    }

    /**
     * @param $providerId
     * @param $socialId
     * @return mixed
     */
    protected function findUserBySocialId($providerId, $socialId)
    {
        return Token::whereProviderId($providerId)->whereSocialId($socialId)->first();
    }

    /**
     * @param $providerId
     * @param $userId
     * @param $socialId
     * @param $token
     * @return mixed
     */
    protected function createSocialToken($providerId, $userId, $socialId, $token)
    {
        return Token::create([
            'provider_id' => $providerId,
            'user_id' => $userId,
            'social_id' => $socialId,
            'social_token' => $token,
        ]);
    }
} 