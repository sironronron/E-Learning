<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Authenticated User
use Auth;

// Courses
use App\Models\Course\Course;
use App\Models\Course\CourseCategory;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;
use App\Models\Course\CourseSectionQuiz;

// Instructor
use App\User;

// Cart
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;

class PageController extends Controller
{
    public function welcome()
    {
        $courses = Course::where('status', 'PUBLISHED')
            ->with(['category', 'user'])
            ->get(['image', 'title', 'excerpt', 'price', 'discount', 'has_discount', 'id', 'teacher_id', 'category_id', 'slug', 'free_course']);

        return response()
            ->json([
                'courses' => $courses
            ]);
    }

    public function showCourse($slug)
    {

        $course = Course::where('status', 'PUBLISHED')
            ->with(['category', 'requirements', 'outcomes', 'whos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        $enrolled_students = $course->students()->count();

            $enrolled_at = null;

            if ($enrolled_course == true) {
                $enrolled_at = $course->students()->where('user_id', \Auth::id())
                    ->where('course_id', $course->id)
                    ->first();
            }

            // add delay on course view
            $visitorIp = \Request::getClientIp(true);

            views($course)
                ->collection('course')
                ->overrideVisitor($visitorIp)
                ->record();

        $sections = CourseSection::where('course_id', $course->id)
            ->with(['lessons'])
            ->get(['id', 'title']);

            $lessons = CourseSectionLesson::where('course_id', $course->id)
                ->where('duration', '!=', null)
                ->get(['course_id', 'course_section_id', 'title', 'lesson_type', 'duration', 'summary', 'order_index']);

            $quizzes = CourseSectionQuiz::where('course_id', $course->id)
                ->get([
                    'title', 'slug', 'course_id', 'instruction', 'course_curriculum_section_id'
                ]);

            // Course Complete Lesson Duration
            $lessonDurations = CourseSectionLesson::where('course_id', $course->id)
                ->where('duration', '!=', null)
                ->pluck('duration');

                // Calculate total hours
                $hrs = 0;
                $mins = 0;
                $secs = 0;

                foreach ($lessonDurations as $time) {
                    list ($hours, $minutes, $seconds) = explode(':', $time);

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

        $instructor = User::where('id', $course->teacher_id)
            ->with(['courses'])
            ->firstOrFail();

        $countLessons = CourseSectionLesson::where('course_id', $course->id)
            ->count();

        $mightLikes = Course::where('slug', '!=', $slug)
            ->with(['user', 'category'])
            ->where('status', 'PUBLISHED')
            ->where('category_id', $course->category_id)
            ->inRandomOrder()
            ->take(3)
            ->get(['id', 'teacher_id', 'title', 'excerpt', 'image', 'slug', 'price', 'discount', 'has_discount', 'free_course', 'category_id', 'created_at', 'updated_at', 'image_public_id']);

        return response()
            ->json([
                'course' => $course,
                'mightLikes' => $mightLikes,
                'sections' => $sections,
                'countLessons' => $countLessons,
                'totalDuration' => $totalDuration,
                'lessons' => $lessons,
                'quizzes' => $quizzes,
                // 'addedToCart' => $addedToCart,
                'enrolled_course' => $enrolled_course,
                'enrolled_at' => $enrolled_at,
                'enrolled_students' => $enrolled_students,
                'instructor' => $instructor
            ]);
    }

    public function getCourseOverviewUrl($slug)
    {
        $courseOverviewURL = Course::where('status', 'PUBLISHED')
            ->where('slug', $slug)
            ->firstOrFail(['course_overview_url', 'course_overview_provider', 'image']);

        return response()
            ->json([
                'courseOverviewURL' => $courseOverviewURL
            ]);
    }

    public function showInstructor($username)
    {   
        $instructor = User::where('username', $username)
            ->firstOrFail();   
        
        $courses = Course::where('teacher_id', $instructor->id)
            ->where('status', 'PUBLISHED')
            ->with(['category', 'user'])
            ->get(['image', 'title', 'excerpt', 'price', 'discount', 'has_discount', 'id', 'teacher_id', 'category_id', 'slug']);

        return response()
            ->json([
                'instructor' => $instructor,
                'courses' => $courses
            ]);
    }

    public function showCategory($slug)
    {
        $category = CourseCategory::where('slug', $slug)
            ->firstOrFail();

        $courses = Course::where('category_id', $category->id)
            ->with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $countCourses = Course::where('category_id', $category->id)
            ->count();
            
        $mostPopular = Course::orderByViews('desc')
            ->where('category_id', $category->id)
            ->with(['user', 'views'])
            ->get(['id', 'title', 'slug', 'image', 'image_public_id', 'excerpt', 'has_discount', 'free_course', 'price', 'discount', 'teacher_id']);

        $featuredCourse = Course::where('category_id', $category->id)
            ->where('featured', 1)
            ->with(['user', 'category', 'sections', 'lessons'])
            ->firstOrFail();

        return response()
            ->json([
                'category' => $category,
                'courses' => $courses,
                'mostPopular' => $mostPopular,
                'featuredCourse' => $featuredCourse,
                'countCourses' => $countCourses
            ]);
    }

    public function navCategories()
    {
        $categories = CourseCategory::get(['id', 'name', 'slug', 'icon']);
        
        return response()
            ->json([
                'categories' => $categories
            ]);
    }

}
