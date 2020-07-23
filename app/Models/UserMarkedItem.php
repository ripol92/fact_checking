<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserMarkedItem extends Model
{
    public $timestamps = false;

    protected $table = 'user_marked_item';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markedItem()
    {
        return $this->belongsTo(MarkedItem::class);
    }
}
