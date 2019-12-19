<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Model
use App\Models\Course\Course;
use App\Models\Course\CourseSection;

class CourseSectionController extends Controller
{
    public function __construct() {
        return $this->middleware('auth:api');
    }
    /**
     * Create new section in courses
     * 
     * @param int id // Course ID
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);

        $course = Course::where('id', $id)
            ->firstOrFail();

        $section = new CourseSection($request->all());
        $section->slug = str_slug($request->title, '-');
        $section->course_id = $course->id;

        $section->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $section->id,
                'message' => "Section succesfully saved!"
            ]);
    }
}
