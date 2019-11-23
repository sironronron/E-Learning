<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Authenticated User
use Auth;
// Courses
use App\Models\Course\Course;
use App\Models\Course\CourseCategory;
// Instructor
use App\User;

class PageController extends Controller
{
    public function welcome()
    {
        $courses = Course::where('status', 'PUBLISHED')
            ->with(['category', 'user'])
            ->get(['image', 'title', 'excerpt', 'price', 'discount', 'has_discount', 'id', 'teacher_id', 'category_id', 'slug']);

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

        $mightLikes = Course::where('slug', '!=', $slug)
            ->with(['user', 'category'])
            ->where('status', 'PUBLISHED')
            ->where('category_id', $course->category_id)
            ->inRandomOrder()
            ->get(['id', 'teacher_id', 'title', 'excerpt', 'image', 'slug', 'price', 'discount', 'has_discount', 'free_course', 'category_id']);

        return response()
            ->json([
                'course' => $course,
                'mightLikes' => $mightLikes
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

    public function navCategories()
    {
        $categories = CourseCategory::get(['id', 'name', 'slug']);
        
        return response()
            ->json([
                'categories' => $categories
            ]);
    }

}
