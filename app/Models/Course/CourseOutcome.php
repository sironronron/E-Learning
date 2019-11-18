<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseOutcome extends Model
{
    protected $table = 'course_outcomes';

    protected $fillable = [
        'course_id', 'description'
    ];

    public $timestamps = false;
}
