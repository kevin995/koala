<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class Score
 */
class Score extends Model
{

    protected $table = 'scores';

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

    ];

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}