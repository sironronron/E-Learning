<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;
use App\Models\Course\CourseUserProgress;

// Course Questions and Answers
use App\Models\Course\CourseQANDA;

// Auth
use Auth;

class UserCoursesController extends Controller
{
	public function __construct()
	{
		return $this->middleware('auth:api');
	}
	/**
	 * Get my array of my courses
	 * 
	 */
	public function myCourses()
	{
		$enrolled_courses = null;

        $enrolled_courses = Course::whereHas('students', function($query) {
            $query->where('user_id', \Auth::id());
        })
        ->with(['user:id,name', 'firstLesson:id,course_id', 'firstProgress' => function ($query) {
        	$query->where('user_id', \Auth::id());
        }, 'rating' => function ($query) {
        	$query->where('user_id', \Auth::id());
		}])
		->withCount(['lessons'])
		->withCount(['progress' => function ($query) {
			$query->where('user_id', \Auth::id())
				->where('status', 1);
		}])
        ->orderBy('id', 'desc')
        ->get();

        return response()
            ->json([
                'enrolled_courses' => $enrolled_courses
            ]);
	}

	/**
	 * Get course lessons
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showCourseLessons($id, $slug)
	{
		$user = Auth::user();

		$course = Course::where('slug', $slug)
			->with(['user:id,name,introduction,email,avatar,avatar_public_id,biography', 'rating' => function ($query) {
				$query->where('user_id', Auth::user()->id);
			}])
			->firstOrFail();

		if ($user->id === $course->teacher_id) {
			$enrolled_course = true;
		} else {
			$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();
		}

		if ($enrolled_course == true) {
			$showCourse = $course;
		} else {
			return response()
				->json([
					'enrolled' => false,
					'message' => 'You are not enrolled to this course.'
				], 401);
		}

		$sections = CourseSection::where('course_id', $showCourse->id)
			->withCount(['lessons'])
			->withCount(['progress' => function ($query) {
				$query->where('status', 1)
					->where('user_id', Auth::user()->id);
			}])
			->orderby('order_index', 'asc')
			->get(['title', 'slug', 'id', 'order_index']);

		$lessons = CourseSectionLesson::where('course_id', $showCourse->id)
			->with(['getProgress' => function ($query) {
				$query->where('user_id', Auth::user()->id);
			}])
			->get();

		$lesson = CourseSectionLesson::find($id);

		$userProgress = CourseUserProgress::where('status', 1)
			->where('user_id', Auth::user()->id)
			->where('course_id', $showCourse->id)
			->count();
		
		return response()
			->json([
				'showCourse' => $showCourse,
				'sections' => $sections,
				'lessons' => $lessons,
				'progress' => $userProgress,
				'lesson' => $lesson
			]);
	}

	public function getCourseDetails($slug)
	{
		$user = Auth::user();
		$course = Course::where('slug', $slug)
			->with(['user'])
			->firstOrFail();

		if ($user->id === $course->teacher_id) {
			$enrolled_course = true;
		} else {
			$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();
		}

		if ($enrolled_course == true) {
			$courseDetails = $course;
		} else {
			return response()
				->json([
					'enrolled' => false,
					'message' => 'You are not enrolled to this course.'
				], 401);
		}

		$students = $course->students()->count();

		$lessons = CourseSectionLesson::where('course_id', $courseDetails->id)
			->orderBy('order_index', 'asc')
			->get();

		$lessonDurations = CourseSectionLesson::where('course_id', $courseDetails->id)
			->where('lesson_type', 'VIDEO')
			->get(['duration']);
			// Calculate total hours
            $hrs = 0;
            $mins = 0;
            $secs = 0;
            foreach ($lessonDurations as $time) {
                list ($hours, $minutes, $seconds) = explode(':', $time->duration);

                $hrs += (int) $hours;
                $mins += (int) $minutes;
                $secs += (int) $seconds;

                // Convert each 60 minutes to an hour
                if ($mins >= 60) {
                    $hrs++;
                    $mins -= 60;
                }

                // Convert each 60 seconds to a minute
                if ($secs >= 60) {
                    $mins++;
                    $secs -= 60;
                }
            }
            $totalDuration = sprintf('%d:%d:%d', $hrs, $mins, $secs);

		return response()
			->json([
				'courseDetails' => $courseDetails,
				'students' => $students,
				'totalDuration' => $totalDuration,
				'lessonCount' => count($lessons),
			]);
	}

	public function getQandA($slug) 
	{
		$user = Auth::user();

		$course = Course::where('slug', $slug)
			->firstOrFail(['id', 'teacher_id']);

		if ($user->id === $course->teacher_id) {
			$enrolled_course = true;
		} else {
			$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();
		}

		if ($enrolled_course == true) {
			$courseQna = $course;
		} else {
			return response()
				->json([
					'enrolled' => false,
					'message' => 'You are not enrolled to this course.'
				], 401);
		}

		$qnas = CourseQANDA::where('course_id', $courseQna->id)
			->where('parent_id', null)
			->orderBy('created_at', 'desc')
			->with(['user', 'replies'])
			->get();

		return response()
			->json([
				'qnas' => $qnas,
				'slug' => $courseQna->slug,
				'courseId' => $courseQna->id,
				'teacherId' => $courseQna->teacher_id
			]);
	}

	/**
	 * Show lessons video
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function showLesson($slug, $id)
	{
		$user = Auth::user();

		$course = Course::where('slug', $slug)
			->firstOrFail();

		if ($user->id === $course->teacher_id) {
			$enrolled_course = true;
		} else {
			$enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count();
		}

		if ($enrolled_course == true) {
			$enrolledCourse = $course;
			$lesson = CourseSectionLesson::where('id', $id)
				->firstOrFail();
		} else {
			// If user is not enrolled
			return response()
				->json([
					'enrolled' => false,
					'message' => "Sorry, but	 you are not enrolled to this course."
				]);
		}
	
		return response()
			->json([
				'enrolledCourse' => $enrolledCourse,
				'lesson' => $lesson
			]);

	}

}
