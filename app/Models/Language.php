<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'order'
    ];

    public $timestamps = false;
}
