<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

// Search Model
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

// Record Views of Model
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Course extends Model implements Searchable, ViewableContract
{
    use Viewable;

    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'excerpt', 'description', 'category_id',
        'status', 'language_id', 'level', 'free_course', 'price',
        'has_discount', 'discount', 'image', 'course_overview_provider', 'course_overview_url',
        'meta_keywords', 'meta_description'
    ];

    /**
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    /**
     * @return array
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Course\CourseCategory');
    }

    /**
     * @return array
     */
    public function lessons()
    {
        return $this->hasMany('App\Models\Course\CourseSectionLesson');
    }

    /**
     * @return array
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Course\CourseSection');
    }

    /**
     * @return array
     */
    public function requirements()
    {
        return $this->hasMany('App\Models\Course\CourseRequirement');
    }

    /**
     * @return array
     */
    public function outcomes()
    {
        return $this->hasMany('App\Models\Course\CourseOutcome');
    }

    /**
     * @return array
     */
    public function whos()
    {
        return $this->hasMany('App\Models\Course\CourseWho');
    }

    /**
     * @return array
     */
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
