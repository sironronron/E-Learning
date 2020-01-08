<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Searchable
use Spatie\Searchable\Search;
// Searching Datas
use App\Models\Course\Course;
use App\Models\Course\CourseCategory;
use Spatie\Searchable\ModelSearchAspect;

class SearchController extends Controller
{
    public function searchCourses(Request $request)
    {
        $this->validate($request, [
            'q' => 'required|string'
        ]);

        $search = $request->get('q');
        // $searchResults = (new Search())
        //     ->registerModel(CourseCategory::class, ['id', 'name', 'slug'])
        //     ->registerModel(Course::class, ['id', 'title', 'image', 'has_discount', 'free_course', 'teacher_id', 'category_id', 'price', 'discount'])
        //     ->search($search);
        $searchResults = (new Search())
            ->registerModel(Course::class, function(ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('title') // return results for partial matches on usernames
                    ->addSearchableAttribute('language')
                    ->with(['user', 'outcomes', 'category'])
                    ->paginate(5);
            })->search($search);

        $forBeginners = Course::where('level', 'BEGINNER')
            ->where('status', 'PUBLISHED')
            ->with(['user', 'category'])
            ->take(5)
            ->get(['id', 'image', 'image_public_id', 'title', 'slug', 'category_id', 'teacher_id', 'excerpt', 'free_course', 'price', 'discount', 'has_discount', 'created_at', 'updated_at', 'level']);

        
        return response()
            ->json([
                'searchResults' => $searchResults,
                'forBeginners' => $forBeginners
            ]);
    }
}
