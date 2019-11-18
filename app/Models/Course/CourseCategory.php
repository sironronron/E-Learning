<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $table = 'course_categories';

    protected $fillable = [
        'parent_id', 'name', 'slug', 'order', 'icon'  
    ];
}
