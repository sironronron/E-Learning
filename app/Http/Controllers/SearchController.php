<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Searchable
use Spatie\Searchable\Search;
// Searching Datas
use App\Models\Course\Course;
use App\Models\Course\CourseCategory;

class SearchController extends Controller
{
    public function searchCourses(Request $request)
    {
        $this->validate($request, [
            'q' => 'required|string'
        ]);

        $search = $request->get('q');
        $searchResults = (new Search())
            ->registerModel(CourseCategory::class, ['id', 'name', 'slug'])
            ->registerModel(Course::class, ['id', 'title', 'image', 'has_discount', 'free_course', 'teacher_id', 'category_id', 'price', 'discount'])
            ->search($search);

        return response()
            ->json([
                'searchResults' => $searchResults
            ]);
    }
}
