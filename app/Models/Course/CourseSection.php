<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'course_curriculum_sections';

    protected $fillable = [
        'course_id', 'title', 'slug', 'order_index'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Models\Course\CourseSectionLesson', 'course_section_id');
    }

    public function quizzes()
    {
        return $this->hasMany('App\Models\Course\CourseSectionQuiz', 'section_id');
    }

    public function quizBank()
    {
        return $this->hasOne('App\Models\Course\CourseQuizBank', 'section_id');
    }

    public function progress()
    {
        return $this->hasMany('App\Models\Course\CourseUserProgress', 'section_id');
    }
}
