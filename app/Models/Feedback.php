<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Feedback
 * @package App\Models
 * @property integer $id
 * @property string $feedback
 * @property integer $user_id
 * @property boolean $email_to_admin_sent
 */

class Feedback extends Model {
    protected $table = "feedbacks";

    protected $guarded = ["id"];

    /**
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
