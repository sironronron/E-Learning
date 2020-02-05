<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseAnnouncement extends Model
{
    protected $table = 'course_announcements';

    protected $fillable = [
    	'course_id', 'user_id', 'title', 'description'
    ];

    /**
     * @return array
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * @return array
     */
    public function course()
    {
    	return $this->belongsTo('App\Models\Course\Course');
    }
}
