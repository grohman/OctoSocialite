<?php namespace Grohman\Socialite\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

/**
 * Providers Back-end Controller
 */
class Providers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Grohman.Socialite', 'socialite', 'providers');
    }

}