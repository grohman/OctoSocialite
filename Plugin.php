<?php namespace Grohman\Socialite;

use Illuminate\Foundation\AliasLoader;
use System\Classes\PluginBase;

/**
 * socialite Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    /**
     *
     */
    public function boot()
    {
        app()->register('Laravel\Socialite\SocialiteServiceProvider');
        AliasLoader::getInstance()->alias('Socialite', 'Laravel\Socialite\Facades\Socialite');

    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'OctoSocialite',
            'description' => 'Laravel Socialite wrapper',
            'author'      => 'Daniel Podrabinek aka grohman [podrabinek@idesigning.ru]',
            'icon'        => 'icon-users'
        ];
    }

    /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Socialite',
                'description' => 'Управление авторизацией в социальных приложениях',
                'icon' => 'icon-users',
                'url'         => \Backend::url('grohman/socialite/providers'),
                'order' => 600
            ]
        ];
    }

    public function registerComponents()
    {
        return ['Grohman\Socialite\Components\Socialite' => 'socialite'];
    }
}
