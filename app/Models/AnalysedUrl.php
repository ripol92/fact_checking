<?php

namespace App\Models;

use App\Database\HasUUIDPrimaryKey;
use Illuminate\Database\Eloquent\Model;

/**
 * App
 *
 * @property string|null $id
 * @property string|null $url
 * @property string $article
 * @property string $lng
 * @property string $adjectives_analyse json
 * @property string $text_ru json
 * @property array|null $image_links
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property boolean $text_ru_response_received
 * @property boolean $fal_detector_finished
 * @property boolean $notifications_send
 **/
class AnalysedUrl extends Model
{
    protected $casts = [
        'image_links' => 'array',
        "adjectives_analyse" => "json",
        "updated_at" => "datetime",
        "created_at" => "datetime"
    ];

    protected $keyType = 'string';

    use HasUUIDPrimaryKey;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imageChecks()
    {
        return $this->hasMany(ImageCheck::class, "identifier");
    }
}
