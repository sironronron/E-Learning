<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Spatie Searchable
use Spatie\Searchable\Search;
// Course Model
use App\Models\Course\Course;

class SearchController extends Controller
{
    public function search($request)
    {
        $this->validate($request, [
            'q' => 'required|string'
        ]);

        $search = $request->get('q');
        $searchResults = (new Search())
            ->registerModal(Course::class, ['id', 'title', 'excerpt', 'slug', 'image', 'has_discount', 'free_course', 'created_at', 'discount'])
            ->search($search);

        return response()
            ->json([
                'searchResults' => $searchResults
            ]);
    }
}
