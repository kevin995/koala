<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 */
class Feedback extends Model
{
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

        
}