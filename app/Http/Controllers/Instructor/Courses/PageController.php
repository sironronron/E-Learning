<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course\Course;

use Illuminate\Support\Facades\Auth;

use Spatie\Searchable\ModelSearchAspect;


class PageController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');   
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'search_query' => 'required|string'
        ]);

        $search = $request->get('search_query');

        $searchResults = (new Search())
            ->registerModel(Course::class, function (ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('language')
                    ->with(['user', 'outcomes', 'category', 'whos', 'requirements'])
                    ->where('teacher_id', Auth::user()->id)
                    ->paginate(10);
            })->search($search);
 
        return response()
            ->json([
                'searchResults' => $searchResults
            ]);
    }
}
