<?php

namespace App;

use App\Database\HasUUIDPrimaryKey;
use Illuminate\Database\Eloquent\Model;

/**
 * App
 *
 * @property string|null $id
 * @property string|null $url
 * @property string $article
 * @property string $text_ru json
 * @property string|null $image_links
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 **/

class AnalysedUrl extends Model
{
    protected $keyType = 'string';
    use HasUUIDPrimaryKey;
    protected $guarded = [];
}
