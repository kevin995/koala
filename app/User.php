<?php

namespace App;

use App\Models\Course;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $key = 'id';
            if(empty($model->{$key})) {
                $model->{$key} = (string)Uuid::uuid4();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'speaker', 'id');
    }

    public function isAdmin()
    {
        return $this->id == config('auth.admin_id');
    }

    public function getUnscoredCourses()
    {
        $res = Course::with(['speakerInfo', 'scores'])
            ->where('isclose', '=', 1)
            ->where('speaker', '!=', Auth::user()->id)
            ->orderBy('date', 'DESC')
            ->get()->filter(function ($item) {

                if (!in_array(Auth::user()->id, array_pluck($item->scores->toArray(), 'scorer'))) {
                    return true;
                }
                return false;
            });

        return $res;
    }

    public function getScoredCourses()
    {
        $res = Course::with(['speakerInfo', 'scores'])->orderBy('date', 'DESC')
            ->get()->filter(function ($item) {
                if (in_array(Auth::user()->id, array_pluck($item->scores->toArray(), 'scorer'))) {
                    return true;
                }
                return false;
            })->map(function ($item) {
                $score = $item->scores->where('scorer', '=', Auth::user()->id)->first();
                $item['score'] = $score->score;
                return $item;
            });

        return $res;
    }

}
