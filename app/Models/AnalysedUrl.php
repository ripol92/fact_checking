<?php

namespace App\Models;

use App\Database\HasUUIDPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $url
 * @property string $article
 * @property string|mixed $text_ru json
 * @property string[] $image_links
 * @property string $lng
 * @property string|mixed $adjectives_analyse json
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 **/
class AnalysedUrl extends Model
{
    use HasUUIDPrimaryKey;

    protected $keyType = 'uuid';

    protected $fillable = [
        "url",
        "article",
        "text_ru",
        "image_links",
        "lng",
        "adjectives_analyse"
    ];

    protected $casts = [
        "image_links" => "array",
        "text_ru" => "json",
        "adjectives_analyse" => "json",
        "updated_at" => "datetime",
        "created_at" => "datetime"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imageChecks()
    {
        return $this->hasMany(ImageCheck::class, "identifier");
    }
}
