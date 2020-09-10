<?php

namespace App;

use App\Models\MarkedItem;
use App\Models\UserMarkedItem;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App
 * @property int $id
 * @property string $name
 * @property string $email
 * @property boolean $is_admin
 * @property string $password
 * @property Carbon|string $updated_at
 * @property Carbon|string $created_at
 * @property string|null $firebase_token
 * @property MarkedItem[] $markedNews
 * @property string|null $phone_number
 * @property string|null $facebook_link
 * @property string|null $telegram_account
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firebase_token',
        'phone_number',
        'facebook_link',
        'telegram_account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMarkedItem()
    {
        return $this->hasMany(UserMarkedItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function markedNews()
    {
        return $this->belongsToMany(MarkedItem::class, 'user_marked_item');
    }

    /**
     * @param Notification $notification
     * @return string|null
     */
    public function routeNotificationForFirebase(Notification $notification)
    {
        return $this->firebase_token;
    }
}
