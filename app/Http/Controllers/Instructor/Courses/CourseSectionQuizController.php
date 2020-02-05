<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Models
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionQuiz;

// Course Quiz Bank
use App\Models\Course\CourseQuizBank;

class CourseSectionQuizController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }


    /**
     * Get All Sections
     * 
     * @param $course_section_id
     * @return Illuminate\Http\Response
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
            'instruction' => 'required|max:500'
        ]);

        $quiz = new CourseSectionQuiz($request->all());
        $quiz->slug = str_slug($request->title, '-');
        
        $quiz->save();

        return response()
            ->json([
                'saved' => true,
                'quiz' => $quiz,
                'message' => 'Quiz Saved'
            ]);

    }
}
