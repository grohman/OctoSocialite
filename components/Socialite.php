<?php namespace Grohman\Socialite\Components;

use Cms\Classes\ComponentBase;
use Grohman\Socialite\Models\Provider as SocialiteProvider;

class Socialite extends ComponentBase
{

    public $socialite;

    public function componentDetails()
    {
        return [
            'name' => 'Socialite Component',
            'description' => 'Social apps listing'
        ];
    }

    public function defineProperties()
    {
        return [ ];
    }

    public function onRun()
    {
        $result = [];
        $providers = SocialiteProvider::orderBy('client_name', 'asc')->lists('client_id', 'client_name');
        $providersNames = SocialiteProvider::getAllProviders();
        foreach($providersNames as $key => $value) {
            if(isset($providers[$key])) {
                $result[$value] = url('/grohman/socialite', $key);
            }
        }

        $this->socialite = $result;
    }

}