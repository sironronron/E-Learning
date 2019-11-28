<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course\Course;

use Auth;

class PageController extends Controller
{
	public function __construct() 
    {
        return $this->middleware('auth:api');
    }
    /**
	*	All Active Courses
	*/
	public function activeCourses()
	{
		$activeCourses = Course::where('teacher_id', Auth::user()->id)
			->where('status', 'PUBLISHED')
			->with(['user', 'category'])
			->get(['id', 'title', 'teacher_id', 'slug', 'category_id', 'status']);

		$countCourses = Course::where('teacher_id', Auth::user()->id)
			->where('status', 'PUBLISHED')
			->count();

		return response()
			->json([
				'activeCourses' => $activeCourses,
				'countCourses' => $countCourses
			]);
	}
}
