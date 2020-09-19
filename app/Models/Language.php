<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @package App\Models\
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $order
 */
class Language extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'order'
    ];

    public $timestamps = false;
}
