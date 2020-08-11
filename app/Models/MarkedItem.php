<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MarkedItem extends Model
{
    protected $fillable = [
        'link',
        'description',
        'title',
        'date',
        'lang',
        'is_analyzed',
    ];

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
}
