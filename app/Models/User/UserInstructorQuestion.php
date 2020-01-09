<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserInstructorQuestion extends Model
{
    protected $table = 'user_instructor_questions';

    protected $fillable = [
        'teaching_skills', 'user_id', 'teaching_skill_other', 'video_skills', 'audience_number'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
