<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseUserProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'user_id', 'course_id', 'lesson_id', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Models\Course\CourseSectionLesson');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course\Course');
    }
}
