<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ImageCheck
 * @package App\Models
 * @property string $identifier
 * @property string $image_path
 * @property string $global_detector_error
 * @property string $local_detector_error
 * @property string $analyze_msg
 * @property string $results_path
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class ImageCheck extends Model
{
    protected $fillable = [
        "image_path",
        "global_detector_error",
        "local_detector_error",
        "analyze_msg",
        "results_path",
    ];

    protected $casts = [
        "updated_at" => "datetime",
        "created_at" => "datetime",
    ];
}
