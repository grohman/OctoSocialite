<?php namespace Grohman\Socialite\Models;

use Model;

/**
 * Token Model
 */
class Token extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grohman_socialite_tokens';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['provider_id', 'user_id', 'social_id', 'social_token'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'provider' => 'Grohman\Socialite\Models\Provider',
        'user' => 'Rainlab\User\Models\User',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}