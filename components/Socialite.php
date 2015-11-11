<?php namespace Grohman\Socialite\Components;

use Cms\Classes\ComponentBase;
use Grohman\Socialite\Models\Provider;
use Illuminate\Support\ViewErrorBag;
use Session;
use URL;

class Socialite extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Socialite Component',
            'description' => 'Выводит список доступных для авторизации соц.сетей в social_login_links'
        ];
    }

    public function defineProperties()
    {
        return [ ];
    }

    public function onRun()
    {
        $result = [];
        $providers = Provider::orderBy('client_name', 'asc')->lists('client_id', 'client_name');
        $providersNames = Provider::getAllProviders();
        foreach($providersNames as $key => $value) {
            if(isset($providers[$key])) {
                $result[$value] = url('/grohman/socialite', $key);
            }
        }
        $this->page[ 'social_login_links' ] = $result;
    }

}