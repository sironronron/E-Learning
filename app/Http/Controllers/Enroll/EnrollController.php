<?php

namespace App\Http\Controllers\Enroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;

use Auth;

// Notification
use Notification;
use App\Notifications\CourseSubscriptionNotification;

class EnrollController extends Controller
{
	/**
	 * Add a middleware to request
	 */
    public function __construct()
    {
    	return $this->middleware('auth:api');
    }

    /**
     * Enroll student to course
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function enroll(Request $request, $id)
    {
		$user = Auth::user();

    	$course = Course::where('id', $id)
    		->firstOrFail();
        
        if ($user->id == $course->teacher_id) {
            return response()
                ->json([
                    'enrolled' => false,
                    'message' => "Sorry, you can't enroll on your own course."
                ], 401);
        } else {
            $course->students()->attach(Auth::user()->id);
        }

		$appUrl = config('app.client_url', config('app.url'));
		
		$details = [
			'subject' => "Hello $user->name! Welcome to $course->title",
            'greeting' => 'Enrollment Confirmation',
            'body' => "Thanks for enrolling in the course, " . '"' . $course->title . '"!',
            'actionText' => 'Start Learning',
            'actionURL' => url("$appUrl"),
        ];

		Notification::send($user, new CourseSubscriptionNotification($details));

    	return response()
    		->json([
    			'enrolled' => true,
    			'message' => "Great pick! You are now enrolled to $course->title."
    		]);
    }

    /**
     * Show enrolled course
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$course = Course::where('id', $id)
    		->with(['lessons', 'user'])
    		->firstOrFail();

    	$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();

    	if ($enrolled_course == true) {
    		$showCourse = $course;
    	} else {
    		return response()
    			->json([
    				'message' => 'You are not enrolled to this course.'
    			]);
    	}

    	$mightLikes = Course::where('id', '!=', $id)
            ->with(['user', 'category'])
            ->where('status', 'PUBLISHED')
            ->where('category_id', $course->category_id)
            ->inRandomOrder()
            ->take(5)
            ->get(['id', 'teacher_id', 'title', 'excerpt', 'image', 'slug', 'price', 'discount', 'has_discount', 'free_course', 'category_id', 'created_at', 'updated_at', 'image_public_id']);

        return response()
        	->json([
        		'enrolled_course' => $enrolled_course,
        		'showCourse' => $showCourse,
        		'mightLikes' => $mightLikes
        	]);

	}
	
	/**
	 * Show learning page
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function showLessons($slug, $id)
	{
		$course = Course::where('slug', $slug)
			->with(['sections', 'lessons'])
			->firstOrFail();

		$courseTitle = Course::where('slug', $slug)
			->firstOrFail(['title', 'slug']);

		$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();

		if ($enrolled_course == true) {
			$showCourse = $course;
		}

        $sections = CourseSection::where('course_id', $showCourse->id)
            ->with(['lessons'])
            ->orderBy('order_index', 'asc')
            ->get(['title', 'id', 'slug', 'course_id', 'order_index']);

        $lessons = CourseSectionLesson::where('course_id', $showCourse->id)
            ->orderBy('order_index', 'asc')
            ->get();

        $video = CourseSectionLesson::where('course_id', $showCourse->id)
            ->where('id', $id)
            ->first();

		return response()
			->json([
				'showCourse' => $showCourse,
				'courseTitle' => $courseTitle,
                'sections' => $sections,
                'lessons' => $lessons,
                'video' => $video
			]);
	}
}
