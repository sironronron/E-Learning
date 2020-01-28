<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseQuizBank extends Model
{
    protected $table = 'course_quiz_banks';

    protected $fillable = [
    	'course_id', 'section_id', 'number_of_questions'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];

    public function course()
    {
    	return $this->belongsTo('App\Models\Course\Course');
    }

    public function section()
    {
    	return $this->belongsTo('App\Models\Course\CourseSection');
    }
}
