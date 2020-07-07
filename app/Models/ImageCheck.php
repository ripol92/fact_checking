<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ImageCheck
 * @package App\Models
 * @property string $identifier
 * @property string $image_path
 * @property string $message
 * @property string $results_path
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class ImageCheck extends Model
{
    protected $fillable = [
        "identifier",
        "image_path",
        "message",
        "results_path",
    ];

    protected $casts = [
        "updated_at" => "datetime",
        "created_at" => "datetime",
    ];
}
