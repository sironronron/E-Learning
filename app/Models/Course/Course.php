<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'title', 'slug', 'excerpt', 'description', 'category_id',
        'status', 'language_id', 'level', 'free_course', 'price',
        'has_discount', 'discount', 'image', 'course_overview_provider', 'course_overview_url',
        'meta_keywords', 'meta_description'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Course\CourseCategory');
    }
}
