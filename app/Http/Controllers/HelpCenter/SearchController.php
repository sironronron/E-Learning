<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\HelpCenter\Post;
use App\Models\HelpCenter\Category;

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
            ->registerModel(Post::class, ['title', 'id', 'slug', 'category_id', 'excerpt', 'created_at'])
            ->search($search);
        
        return response()
            ->json([
                'searchResults' => $searchResults,
                'categories' => $categories
            ]);
    }
}
