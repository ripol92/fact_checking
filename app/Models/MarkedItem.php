<?php

namespace App\Models;

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
        return $this->hasOne(UserMarkedItem::class);
    }
}
