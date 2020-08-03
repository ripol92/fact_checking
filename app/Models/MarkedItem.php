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
    ];

    public function userMarkedItem()
    {
        return $this->hasMany(UserMarkedItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_marked_item');
    }
}
