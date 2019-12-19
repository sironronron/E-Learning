<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Models
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;

class CourseSectionLessonController extends Controller
{

    /**
     * Show and return needed data for each lesson
     * 
     * @param $course_id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $course = Course::where('id', $id)
            ->firstOrFail(['id']);
        
        $sections = CourseSection::where('course_id', $course->id)
            ->get(['id', 'title']);

        return response()
            ->json([
                'sections' => $sections
            ]);

    }

    /**
     * Create a lesson on each section
     * 
     * @return Illuminate\Http\Response
     * @return Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'lesson_type' => 'required',
            'lesson_provider' => 'required',
            'summary' => 'required'
        ]);

        $lesson = new CourseSectionLesson($request->all());
        $lesson->slug = str_slug($request->title, '-');

        $lesson->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $lesson->id,
                'message' => 'Lesson successfully added!'
            ]);

    }
}
