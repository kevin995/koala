<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 */
class Feedback extends Model
{
    const TYPE_COURSE = 0;
    const TYPE_OTHER = 1;

    protected $table = 'feedback';

    public $timestamps = true;

    protected $fillable = [
        'type',
        'course_id',
        'proposer',
        'question',
        'score'
    ];

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
        
}