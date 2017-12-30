<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

/**
 * Class Course
 */
class Course extends Model
{

    const STATE_FINISH = 0;
    const STATE_UNSTART = 1;
    const STATE_EXPIRED = 2;

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

    protected $table = 'courses';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'speaker',
        'location',
        'date',
        'isclose'
    ];

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

    public function speakerInfo()
    {
        return $this->belongsTo( User::class, 'speaker', 'id');
    }

    public function getState()
    {
        $res = [
            'state' => 0,
            'text' => '',
        ];
        if ($this->isclose) {
            $res['state'] = static::STATE_FINISH;
            $res['text'] = '已结束';
        } else {
            if (strtotime($this->date) > time()) {
                $res['state'] = static::STATE_UNSTART;
                $res['text'] = '未开始';
            } else {
                $res['state'] = static::STATE_EXPIRED;
                $res['text'] = '已逾期';
            }
        }

        return $res;
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'course_id', 'id');

    }
}