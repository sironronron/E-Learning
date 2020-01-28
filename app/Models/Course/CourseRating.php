<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    protected $table = 'course_ratings';

    protected $fillable = [
    	'user_id', 'course_id', 'rating', 'comments'
    ];

    /**
     * Get User
     *
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * Get Course
	 *
	 */
    public function course()
    {
    	return $this->belongsTo('App\Models\Course\Course');
    }
}
