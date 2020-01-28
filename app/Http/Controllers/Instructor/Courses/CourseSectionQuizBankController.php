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
     * Get number of quiz banks
     *
     */
    public function index()
    {
    	// Code
    }

    /**
     * Create New Quiz Bank
     *
	 */
    public function create()
    {

    }
}
