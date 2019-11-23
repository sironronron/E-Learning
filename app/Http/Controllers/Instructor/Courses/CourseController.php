<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Loggedin User
use Auth;
// Course Model
use App\Models\Course\Course;
// Course Category
use App\Models\Course\CourseCategory;
// Course Requirement
use App\Models\Course\CourseRequirement;
// Course Outcome
use App\Models\Course\CourseOutcome;
// Course For who this is for
use App\Models\Course\CourseWho;

// Storeage
use File;
use Storage;

class CourseController extends Controller
{
    public function __construct() 
    {
        return $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCourses = Course::where('status', 'PUBLISHED')
            ->where('teacher_id', Auth::user()->id)
            ->count();

        $pendingCourses = Course::where('status', 'PENDING')
            ->where('teacher_id', Auth::user()->id)
            ->count();

        $draftCourses = Course::where('status', 'DRAFT')
            ->where('teacher_id', Auth::user()->id)
            ->count();

        $freeCourses = Course::where('free_course', 1)
            ->where('teacher_id', Auth::user()->id)
            ->count();

        $paidCourses = Course::where('free_course', 0)
            ->where('teacher_id', Auth::user()->id)
            ->count();

        $allCourses = Course::where('teacher_id', Auth::user()->id)
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(4, ['id', 'title', 'slug', 'teacher_id', 'category_id', 'status']);


        return response()
            ->json([
                'activeCourses' => $activeCourses,
                'pendingCourses' => $pendingCourses,
                'draftCourses' => $draftCourses,
                'freeCourses' => $freeCourses,
                'paidCourses' => $paidCourses,
                'allCourses' => $allCourses
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CourseCategory::get(['id', 'name', 'slug']);

        return response()
            ->json([
                'categories' => $categories
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:150',
            'description' => 'required|string',
            'category_id' => 'required',
            'level' => 'required',
            'price' => 'present',
            'discount' => 'present',
            'course_overview_provider' => 'required',
            'course_overview_url' => 'required',
            'meta_keywords' => 'required|max:255',
            'meta_description' => 'required|max:120', 
            'requirements' => 'required|array|min:1',
            'requirements.*.description' => 'required|max:255',
            'outcomes' => 'required|array|min:1',
            'outcomes.*.description' => 'required|min:1',
            'whos' => 'required|array|min:1',
            'whos.*.description' => 'required|min:1'
        ]);

        $requirements = [];

        foreach ($request->requirements as $requirement)
        {
            $requirements[] = new CourseRequirement($requirement);
        }

        $outcomes = [];

        foreach ($request->outcomes as $outcome)
        {
            $outcomes[] = new CourseOutcome($outcome);
        }

        $whos = [];

        foreach ($request->whos as $who)
        {
            $whos[] = new CourseWho($who);
        }

        $course = new Course($request->all());

        // Slug
        $course->slug = str_slug($request->title, '-');

        $request->user()
            ->courses()->save($course);

        $course->requirements()
            ->saveMany($requirements);
        $course->outcomes()
            ->saveMany($outcomes);
        $course->whos()
            ->saveMany($whos);

        return response()
            ->json([
                'saved' => true,
                'id' => $course->id,
                'message' => 'You have successfully uploaded your course!'
            ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
