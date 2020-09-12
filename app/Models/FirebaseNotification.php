<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FirebaseNotification
 * @package App\Models
 * @property string $title
 * @property string $text
 * @property int $marked_item_id
 * @property int $user_id
 * @property string $batch_id
 * @property User $user
 * @property MarkedItem $markedItem
 */
class FirebaseNotification extends Model
{
    protected $fillable = [
        "title",
        "text",
        "marked_item_id",
        "user_id",
        "batch_id",
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function markedItem()
    {
        return $this->belongsTo(MarkedItem::class);
    }
}
