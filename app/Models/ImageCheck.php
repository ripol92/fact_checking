<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ImageCheck
 * @package App\Models
 * @property int $id
 * @property string $identifier
 * @property string $image_path
 * @property string $message
 * @property string $results_path
 * @property string|Carbon $updated_at
 * @property string|Carbon $created_at
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
