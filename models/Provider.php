<?php namespace Grohman\Socialite\Models;

use Grohman\Socialite\Models\Token;
use Model;

/**
 * Provider Model
 */
class Provider extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grohman_socialite_providers';
    /**
     * @var array Relations
     */
    public $hasMany = [
        'client' => [ 'Grohman\Socialite\Models\Token' ]
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = [ '*' ];
    /**
     * @var array Fillable fields
     */
    protected $fillable = [ ];

    public static function boot()
    {
        static::updated(function ($model) {
            if ($model->getOriginal('client_id') != $model->getAttribute('client_id')) {
                Token::whereProviderId($model->getAttribute('id'))->delete();
            }
        });
        parent::boot();
    }

    public function getClientNameOptions($current = null)
    {

        $result = $this->getAllProviders();

        if ($current != null) {
            return [ $current => $result[ $current ] ];
        } else {
            $exists = $this->lists('client_name');
            foreach ($exists as $item) {
                unset($result[ $item ]);
            }
        }

        return $result;
    }

    public static function getAllProviders()
    {
        return config()->get('grohman.socialite::providers');
    }

    public function getCallAttribute()
    {
        return (getenv('APP_URL') . '/grohman/socialite/' . $this->client_name);
    }

}