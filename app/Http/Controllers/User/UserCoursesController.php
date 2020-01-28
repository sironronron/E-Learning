<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;

// Course Questions and Answers
use App\Models\Course\CourseQANDA;

// Auth
use Auth;

class UserCoursesController extends Controller
{
	/**
	 * Get my array of my courses
	 * 
	 */
	public function myCourses()
	{
		$enrolled_courses = null;

        if (\Auth::check()) {
            $enrolled_courses = Course::whereHas('students', function($query) {
                $query->where('user_id', \Auth::id());
            })
            ->with(['user'])
            ->orderBy('id', 'desc')
            ->get(['image', 'title', 'excerpt', 'price', 'discount', 'has_discount', 'id', 'teacher_id', 'category_id', 'slug', 'free_course']);
        }
        
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
	public function showCourseLessons($slug)
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
			$showCourse = $course;
		} else {
			return response()
				->json([
					'enrolled' => false,
					'message' => 'You are not enrolled to this course.'
				], 401);
		}

		$sections = CourseSection::where('course_id', $showCourse->id)
			->with(['lessons'])
			->orderby('order_index', 'asc')
			->get(['title', 'slug', 'id', 'order_index']);
		
		return response()
			->json([
				'showCourse' => $showCourse,
				'sections' => $sections,
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
			// Calculate total hours
            $hrs = 0;
            $mins = 0;
            $secs = 0;
            foreach ($lessons as $time) {
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

}
