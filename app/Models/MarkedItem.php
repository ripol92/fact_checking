<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MarkedItem
 * @package App\Models
 * @property string $link
 * @property string $description
 * @property string $title
 * @property string $lang
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property Carbon $date
 * @property boolean $is_analyzed
 */

class MarkedItem extends Model
{
    protected $fillable = [
        'link',
        'description',
        'title',
        'date',
        'lang',
        'is_analyzed',
        'source',
        'img',
        'html_encoded',
        'fact_check_url'
    ];

    protected $casts = ['date'=>'date', 'created_at'=>'datetime', 'updated_at'=>'datetime'];

    public function userMarkedItem()
    {
        return $this->hasMany(UserMarkedItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_marked_item');
    }

    public function userAnalyzedItem()
    {
        return $this->hasMany(UserAnalyzedItem::class);
    }

    public function analyzedUsers()
    {
        return $this->belongsToMany(User::class,'user_analyzed_item');
    }

    public function analyzedResult()
    {
        return $this->hasOne(AnalysedUrl::class, 'url', 'link');
    }
}
