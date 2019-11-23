<?php

namespace App\Models\HelpCenter;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Post extends Model implements Searchable
{
    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\HelpCenter\Category');
    }

    public function getSearchResult(): SearchResult 
    {
        $url = url('/help-center/category/'.$this->categorySlug.'/'. $this->postSlug);
        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    } 
}
