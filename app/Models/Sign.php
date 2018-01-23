<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class Sign
 */
class Sign extends Model
{
    protected $table = 'signs';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $key = 'id';
            if(empty($model->{$key})) {
                $model->{$key} = (string)Uuid::uuid4();;
            }
            $model->created_at = date('Y/m/d H:i', time());
        });
    }

    protected $fillable = [
        'course_id',
        'user_id'
    ];

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

        
}