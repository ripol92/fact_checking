<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RssFeedResource extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'link',
        'order',
        'language_id'
    ];

    public $timestamps = false;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
