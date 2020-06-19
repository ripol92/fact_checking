<?php


namespace App\Models;


use Carbon\Carbon;

/***
 * Class PersonalAccessToken
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $token
 * @property string|mixed abilities
 * @property Carbon $last_used_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class PersonalAccessToken extends \Laravel\Sanctum\PersonalAccessToken
{
    const CREATE_USER = "users:create";

    public static function allTokens()
    {
        return [
            static::CREATE_USER => "Create User"
        ];
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        "updated_at" => "datetime",
        "created_at" => "datetime",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (PersonalAccessToken $pat) {
            $pat->token = hash('sha256', $pat->token);
            if (is_string($pat->abilities)) {
                $pat->abilities = [$pat->abilities];
            }
        });
    }
}
