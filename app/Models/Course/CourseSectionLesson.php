<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseSectionLesson extends Model
{
    protected $table = 'course_curriculum_section_lessons';

    protected $fillable = [
        'course_section_id', 'lesson_image', 'title', 'slug',
        'lesson_type', 'lesson_provider', 'video_url', 'duration', 'lesson_attachment', 'summary',
        'thumbnail', 'course_id', 'order_index', 'text_file'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course\Course');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Course\CourseSection');
    }

    public function progress()
    {
        return $this->hasMany('App\Models\Course\CourseUserProgress', 'lesson_id');
    }

    public function getProgress()
    {
        return $this->hasOne('App\Models\Course\CourseUserProgress', 'lesson_id');
    }

}
