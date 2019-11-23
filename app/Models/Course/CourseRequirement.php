<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $table = 'course_requirements';

    protected $fillable = [
        'course_id','description'
    ];

    public $timestamps = false;
}
