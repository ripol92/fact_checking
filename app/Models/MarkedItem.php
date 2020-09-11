<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MarkedItem
 * @package App\Models
 * @property int $id
 * @property string $link
 * @property string $lang
 * @property string $description
 * @property string $title
 * @property Carbon|string $date
 * @property boolean $is_analyzed
 * @property Carbon|string $updated_at
 * @property Carbon|string $created_at
 * @property string|mixed $html_encoded
 * @property string|null $source
 * @property string $img
 * @property string|null $fact_check_url
 * @property User[]|null $users
 * @property User[]|null $analyzedUsers
 * @property AnalysedUrl|null $analyzedResult
 */
class MarkedItem extends Model
{
    protected $fillable = [
        "link",
        "lang",
        "description",
        "title",
        "date",
        "is_analyzed",
        "html_encoded",
        "source",
        "img",
        "fact_check_url",
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_marked_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAnalyzedItem()
    {
        return $this->hasMany(UserAnalyzedItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function analyzedUsers()
    {
        return $this->belongsToMany(User::class, 'user_analyzed_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function analyzedResult()
    {
        return $this->hasOne(AnalysedUrl::class, 'url', 'link');
    }
}
