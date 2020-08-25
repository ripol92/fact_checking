<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAnalyzedItem extends Model
{
    public $timestamps = false;

    protected $table = 'user_analyzed_item';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function analyzedItem()
    {
        return $this->belongsTo(MarkedItem::class, 'marked_item_id');
    }
}
