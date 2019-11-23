<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseWho extends Model
{
    protected $table = 'course_whos';

    protected $fillable = [
        'course_id', 'description'
    ];  
}
