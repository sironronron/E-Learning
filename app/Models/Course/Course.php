<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Course extends Model implements Searchable
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
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Course\CourseCategory');
    }

    public function requirements()
    {
        return $this->hasMany('App\Models\Course\CourseRequirement');
    }

    public function outcomes()
    {
        return $this->hasMany('App\Models\Course\CourseOutcome');
    }

    public function whos()
    {
        return $this->hasMany('App\Models\Course\CourseWho');
    }

    public function getSearchResult(): \Spatie\Searchable\SearchResult
    {
        $url = url('course/' . $this->slug);
        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
