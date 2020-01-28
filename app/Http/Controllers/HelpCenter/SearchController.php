<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\HelpCenter\Post;
use App\Models\HelpCenter\Category;
use Spatie\Searchable\ModelSearchAspect;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $this->validate($request, [
            'q' => 'required|string'
        ]);

        $categories = Category::where('parent_id', 3)
            ->get(['name', 'slug', 'icon']);

        $search = $request->get('q');
        $searchResults = (new Search())
            ->registerModel(Post::class, function(ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('meta_keywords')
                    ->where('category_id', '!=', null)
                    ->paginate(10, ['title', 'id', 'slug', 'category_id', 'excerpt', 'created_At']);
            })->search($search);

        
        return response()
            ->json([
                'searchResults' => $searchResults,
                'categories' => $categories
            ]);
    }
}
