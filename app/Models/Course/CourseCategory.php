<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class CourseCategory extends Model implements Searchable
{
    protected $table = 'course_categories';

    protected $fillable = [
        'parent_id', 'name', 'slug', 'order', 'icon'  
    ];

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = url('/course/category/', $this->slug);
 
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
