<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Auth User
use Auth;

// Courses
use App\Models\Course\Course;
use App\Models\Course\CourseQuizBank;
use App\Models\Course\CourseSectionQuiz;
use App\Models\Course\CourseSection;

class CourseSectionQuizBankController extends Controller
{
    /**
     * Store new Quiz Bank
     */
    public function store(Request $request) {
        $quizBankExists = CourseQuizBank::where('section_id', $request->section_id)
        	->first();

        $this->validate($request, [
        	'section_id' => 'required',
        	'number_of_questions' => 'required'	
        ]);

        $quizBank = new CourseQuizBank($request->all());
       	
       	if (!$quizBankExists) {
       		$quizBank->save();
       	} else {
       		return response()
       			->json([
       				'saved' => false,
       				'message' => "There's already an existing quiz bank on that section."
       			]);
       	}

        return response()
        	->json([
        		'saved' => true,
        		'bank' => $quizBank,
        		'message' => 'Quiz bank is created'
        	]);
    }

}
