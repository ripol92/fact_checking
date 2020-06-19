<?php


namespace App\Database;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUUIDPrimaryKey
{
    public static function boot()
    {
        parent::boot();

        /**
         * @var Model $user
         */
        static::saving(function ($model) {
            if (is_null($model->id)) {
                $model->id = Uuid::uuid1()->toString();
            }
        });
    }
}
