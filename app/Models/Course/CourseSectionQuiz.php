<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseSectionQuiz extends Model
{
    protected $table = 'course_curriculum_section_quizzes';

    protected $fillable = [
        'title', 'slug', 'instruction', 'section_id', 'course_id', 'bank_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Course\CourseSection');
    }

}
