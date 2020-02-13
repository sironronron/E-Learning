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
use App\Models\Course\CourseUserProgress;
use App\Models\Course\CourseRating;

// Instructor
use App\User;

// Cart
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;

use DB;

class PageController extends Controller
{
    public function welcome()
    {
        $courses = Course::where('status', 'PUBLISHED')
            ->has('lessons')
            ->with(['user:id,name'])
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->select(['courses.id', 'courses.title', 'courses.slug', 'courses.teacher_id', 'courses.price', 'courses.free_course', 'courses.discount', 'courses.price', 'courses.has_discount', 'courses.image', 'courses.image_public_id' , DB::raw(('AVG(rating) as rating_average'))])
            ->groupBy('id')
            ->withCount('ratings')
            ->get();

        $enrolled_courses = null;

        if (Auth::check()) {
            $enrolled_courses = Course::whereHas('students', function($query) {
                $query->where('user_id', Auth::user()->id)
                    ->where('total_time', '!=', '00:00:00');
            })
            ->with(['user:id,name', 'firstLesson:id,course_id', 'firstProgress' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }, 'hasFinishedLesson' => function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->where('status', 1)->count();
            }, 'lessons' => function ($query) {
                $query->where('duration', '!=', null);
            }, 'courseDuration' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->withCount(['progress' => function ($query) {
                $query->where('user_id', \Auth::user()->id)
                    ->where('status', 1);
            }, 'lessons'])
            ->get();
        }

        return response()
            ->json([
                'enrolled_courses' => $enrolled_courses,
                'courses' => $courses
            ]);
    }

    public function showCourse($slug)
    {
        $course = Course::where('status', 'PUBLISHED')
            ->has('lessons')
            ->with(['category:id,name,slug', 'requirements:course_id,description', 'outcomes:course_id,description', 'whos:course_id,description', 'firstLesson:id,course_id'])
            ->withCount('ratings')
            ->where('slug', $slug)
            ->firstOrFail();

        $avgRating = round($course->ratings()->avg('rating'), 1);

        $feedBacks = CourseRating::where('course_id', $course->id)
            ->with(['user:id,name,email,avatar,avatar_public_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        $fiveRating = CourseRating::where('course_id', $course->id)
            ->where('rating', 5)
            ->count();

        $fourRating = CourseRating::where('course_id', $course->id)
            ->whereIn('rating', [4, 4.5])
            ->count();

        $threeRating = CourseRating::where('course_id', $course->id)
            ->whereIn('rating', [3, 3.5])
            ->count();

        $twoRating = CourseRating::where('course_id', $course->id)
            ->whereIn('rating', [2, 2.5])
            ->count();

        $oneRating = CourseRating::where('course_id', $course->id)
            ->whereIn('rating', [0.5, 1, 1.5])
            ->count();

        $enrolled_course = Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        $enrolled_students = $course->students()->count();

            $enrolled_at = null;

            if ($enrolled_course == true) {
                $enrolled_at = $course->students()->where('user_id', \Auth::id())
                    ->where('course_id', $course->id)
                    ->select('users.id', 'name')
                    ->first();
            }

            // add delay on course view
            $visitorIp = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));

            views($course)
                ->collection('course')
                ->overrideVisitor($visitorIp)
                ->record();

        $sections = CourseSection::where('course_id', $course->id)
            ->with(['lessons:id,course_section_id'])
            ->get(['id', 'title']);

            $lessons = CourseSectionLesson::where('course_id', $course->id)
                ->where('duration', '!=', null)
                ->get(['course_id', 'course_section_id', 'title', 'duration', 'order_index']);

            $quizzes = CourseSectionQuiz::where('course_id', $course->id)
                ->get([
                    'title', 'slug', 'course_id', 'instruction', 'section_id'
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
            ->withCount(['courses', 'myReviews'])
            ->firstOrFail(['id', 'name', 'avatar', 'avatar_public_id', 'introduction', 'biography']);

        $instructorDatas = Course::where('teacher_id', $instructor->id)
            ->leftJoin('course_ratings', 'course_ratings.teach_id', '=', 'courses.teacher_id')
            ->select(['courses.id', 'courses.teacher_id', DB::raw(('AVG(rating) as rating_average')) ])
            ->withCount(['students'])
            ->first();

        $countLessons = CourseSectionLesson::where('course_id', $course->id)
            ->count();

        $mightLikes = Course::where('slug', '!=', $slug)
            ->has('lessons')
            ->with(['user:id,name'])
            ->where('status', 'PUBLISHED')
            ->where('category_id', $course->category_id)
            ->inRandomOrder()
            ->take(3)
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->select(['courses.id', 'title', 'slug', 'teacher_id', 'has_discount', 'free_course', 'price', 'discount', 'category_id', 'image', 'image_public_id', 'excerpt', 'language', 'level', 'courses.updated_at', 'courses.created_at',  DB::raw(('avg(rating) as rating_average'))])
            ->groupBy('id')
            ->withCount('ratings', 'students')
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
                'instructor' => $instructor,
                'avgRating' => $avgRating,
                'feedBacks' => $feedBacks,
                'fiveRating' => $fiveRating,
                'fourRating' => $fourRating,
                'threeRating' => $threeRating,
                'twoRating' => $twoRating,
                'oneRating' => $oneRating,
                'instructorDatas' => $instructorDatas,
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
            ->first();

        $courses = Course::has('lessons')
            ->where('category_id', $category->id)
            ->with(['user:id,name', 'views'])
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->select(['courses.id', 'title', 'slug', 'teacher_id', 'has_discount', 'free_course', 'price', 'discount', 'category_id', 'image', 'image_public_id', 'excerpt', 'language', 'level', DB::raw(('avg(rating) as rating_average'))])
            ->orderByViews('desc')
            ->withCount(['ratings', 'lessons', 'students'])
            ->paginate(10);

        $countCourses = $courses->count();

        $featuredCourse = Course::where('category_id', $category->id)
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->select(['courses.id', 'title', 'slug', 'teacher_id', 'has_discount', 'free_course', 'price', 'discount', 'category_id', 'image', 'image_public_id', 'excerpt', 'language', 'level', DB::raw(('avg(rating) as rating_average'))])
            ->groupBy('id')
            ->where('featured', 1)
            ->with(['user:id,name'])
            ->withCount(['lessons', 'ratings', 'students'])
            ->get();

        $mostPopular = Course::has('lessons')
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->select(['courses.id', 'title', 'slug', 'teacher_id', 'has_discount', 'free_course', 'price', 'discount', 'category_id', 'image', 'image_public_id', 'excerpt', 'language', 'level', DB::raw(('avg(rating) as rating_average'))])
            ->groupBy('id')
            ->orderByViews('desc')
            ->take(10)
            ->where('category_id', $category->id)
            ->with(['user:id,name', 'views'])
            ->withCount('ratings')
            ->get();

        return response()
            ->json([
                'category' => $category,
                'mostPopular' => $mostPopular,
                'featuredCourse' => $featuredCourse,
                'courses' => $courses,
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
