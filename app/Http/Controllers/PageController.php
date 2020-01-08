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
// Instructor
use App\User;

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
            ->with(['user', 'category', 'requirements', 'outcomes', 'whos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $sections = CourseSection::where('course_id', $course->id)
            ->with(['lessons', 'quizzes'])
            ->get(['id', 'title']);

            // Course Complete Lesson Duration
            $lessonDurations = CourseSectionLesson::where('course_id', $course->id)
                ->where('duration', '!=', null)
                ->pluck('duration');

                // Calculate total hours
                $x = null;
                $sum = strtotime("00:00:00");
                $sum2 = null;
                $date2 = null;

                foreach ($lessonDurations as $t) {
                    $date = new \DateTime($t);
                    if ($x) {
                        $interval = $date->diff($date2);
                        $sum1 = strtotime($interval->h.':'.$interval->i.':'.$interval->s) - $sum;
                        $sum2 = $sum2 + $sum1;
                    }
                    $date2 = $date;
                    $x = 1;
                }

                $sum3 = $sum + $sum2;

            // End
        $totalDuration = date("H:i:s", $sum3);

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
                'totalDuration' => $totalDuration
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
            
        $mostPopular = Course::where('category_id', $category->id)
            ->with(['user', 'category'])
            ->get(['id', 'title', 'slug', 'image', 'image_public_id', 'excerpt', 'has_discount', 'free_course', 'price', 'discount']);

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
        $categories = CourseCategory::get(['id', 'name', 'slug']);
        
        return response()
            ->json([
                'categories' => $categories
            ]);
    }

}
