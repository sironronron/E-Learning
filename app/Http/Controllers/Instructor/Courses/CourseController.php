<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Loggedin User
use Auth;

// Course Model
use App\Models\Course\Course;
use App\Models\Course\CourseCategory;
use App\Models\Course\CourseRequirement;
use App\Models\Course\CourseOutcome;
use App\Models\Course\CourseWho;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;
use App\Models\Course\CourseSectionQuiz;

// Cloud Storage
use JD\Cloudder\Facades\Cloudder;

// Storage
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
            ->paginate(7, ['id', 'title', 'slug', 'teacher_id', 'category_id', 'status']);

        $courses = Course::where('teacher_id', Auth::user()->id)
            ->count();

        return response()
            ->json([
                'activeCourses' => $activeCourses,
                'pendingCourses' => $pendingCourses,
                'draftCourses' => $draftCourses,
                'freeCourses' => $freeCourses,
                'paidCourses' => $paidCourses,
                'allCourses' => $allCourses,
                'courses' => $courses
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
            'image' => 'required|mimes:jpg,png,jpeg,webp|between:1,6000',
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

        // Save Multiple Requirements
        $requirements = [];

        foreach ($request->requirements as $requirement)
        {
            $requirements[] = new CourseRequirement($requirement);
        }

        // End

        // Save Multiple Outcomes

        $outcomes = [];

        foreach ($request->outcomes as $outcome)
        {
            $outcomes[] = new CourseOutcome($outcome);
        }

        // End

        // Save Multiple For who?
        
        $whos = [];

        foreach ($request->whos as $who)
        {
            $whos[] = new CourseWho($who);
        }

        // End

        $course = new Course($request->all());

        // Check if booleans are true or false
        if (isset($request->discount)) {
            $course->has_discount = 1;
        } else {
            $course->has_discount = 0;
        }

        if (isset($request->price)) {
            $course->free_course = 0;
        } else {
            $course->free_course = 1;
        }

        // Slug
        $course->slug = str_slug($request->title, '-');

        // Cloud Upload using Cloudinary API
        if (isset($request->image)) {
            $image = $request->file('image');
            $name = $request->file('image')->getClientOriginalName();
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null, array('folder' => 'Course Images'));
            list($width, $height) = getImageSize($image_name);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
            $course->image = $image_url;
            $course->image_public_id = Cloudder::getPublicId();
        }
        // End

        $request->user()
            ->courses()->save($course);

        // Save to Public path
        $image->move(public_path('uploads'), $name);

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
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['user', 'requirements', 'whos', 'outcomes', 'category'])
            ->where('teacher_id', Auth::user()->id)
            ->firstOrFail();
            
        return response()
            ->json([
                'course' => $course
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $categories = CourseCategory::get(['id', 'name', 'slug']);

        $course = Course::where('slug', $slug)
            ->with(['user', 'requirements', 'whos', 'outcomes', 'category'])
            ->where('teacher_id', Auth::user()->id)
            ->firstOrFail();

        $sections = CourseSection::where('course_id', $course->id)
            ->orderBy('order_index', 'asc')
            ->get(['id', 'title', 'slug', 'order_index']);

        $lessons = CourseSectionLesson::where('course_id', $course->id)
            ->orderBy('order_index', 'asc')
            ->get();

        $quizzes = CourseSectionQuiz::where('course_id', $course->id)
            ->orderBy('order_index', 'asc')
            ->get();

        return response()
            ->json([
                'course' => $course,
                'categories' => $categories,
                'sections' => $sections,
                'lessons' => $lessons,
                'quizzes' => $quizzes
            ]);
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
            'requirements.*.id' => 'integer|exists:course_requirements',
            'requirements.*.description' => 'required',
            'outcomes' => 'required|array|min:1',
            'outcomes.*.id' => 'integer|exists:course_outcomes',
            'outcomes.*.description' => 'required',
            'whos' => 'required|array|min:1',
            'whos.*.id' => 'integer|exists:course_whos',
            'whos.*.description' => 'required'
        ]);


        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::user()->id)
            ->findOrFail($id);

        $input = $request->all();
        $course->fill($input);

        // Check if booleans are true or false
        if (isset($request->discount)) {
            $course->has_discount = 1;
        } else {
            $course->has_discount = 0;
        }

        if (isset($request->price)) {
            $course->free_course = 0;
        }

        if (isset($request->free_course)) {
            $course->free_course = 1;
        }

        $requirements = [];
        $requirementsUpdated = [];

        foreach ($request->requirements as $requirement) {
            if (isset($requirement['id'])) {
                CourseRequirement::where('course_id', $course->id)
                    ->where('id', $requirement['id'])
                    ->update($requirement);
                $requirementsUpdated[] = $requirement['id'];
            } else {
                $requirements[] = new CourseRequirement($requirement);
            }
        }

        $outcomes = [];
        $outcomesUpdated = [];

        foreach ($request->outcomes as $outcome) {
            if (isset($outcome['id'])) {
                CourseOutcome::where('course_id', $course->id)
                    ->where('id', $outcome['id'])
                    ->update($outcome);
                $outcomesUpdated[] = $outcome['id'];
            } else {
                $outcomes[] = new CourseOutcome($outcome);
            }
        }

        $whos = [];
        $whosUpdated = [];

        foreach ($request->whos as $who) {
            if (isset($who['id'])) {
                CourseWho::where('course_id', $course->id)
                    ->where('id', $who['id'])
                    ->update($who);
                $whosUpdated[] = $who['id'];
            } else {
                $whos[] = new CourseWho($who);
            }
        }

        // Slug
        $course->slug = str_slug($request->title, '-');

        // Cloud Upload/Update using Cloudinary API
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $name = $request->file('image')->getClientOriginalName();
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null, ['folder' => 'Course Images']);
            list($width, $height) = getimagesize($image_name);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
            $course->image = $image_url;
        }

        $course->save();

        CourseRequirement::whereNotIn('id', $requirementsUpdated)
            ->where('course_id', $course->id)
            ->delete();

        CourseOutcome::whereNotIn('id', $outcomesUpdated)
            ->where('course_id', $course->id)
            ->delete();

        CourseWho::whereNotIn('id', $whosUpdated)
            ->where('course_id', $course->id)
            ->delete();

        if (count($requirements)) {
            $course->requirements()
                ->saveMany($requirements);
        }

        if (count($outcomes)) {
            $course->outcomes()
                ->saveMany($outcomes);
        }

        if (count($whos)) {
            $course->whos()
                ->saveMany($whos);
        }

        return response()
            ->json([
                'updated' => true,
                'id' => $course->id,
                'message' => 'You have successfully updated your course!'
            ]);

    }

    public function editImage($slug)
    {   
        $image = Course::where('slug', $slug)
            ->where('teacher_id', Auth::user()->id)
            ->firstOrFail(['id','image']);

        return response()
            ->json([
                'image' => $image
            ]);
    }

    public function updateImage(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,png,jpeg,webp|between:1,6000',
        ]);

        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::user()->id)
            ->findOrFail($id);

        // Cloud Upload/Update using Cloudinary API
            $image = $request->file('image');
            $name = $request->file('image')->getClientOriginalName();
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null, ['folder' => 'Course Images']);
            list($width, $height) = getimagesize($image_name);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
            $course->image = $image_url;
            $course->image_public_id = Cloudder::getPublicId();

        $course->save();

        return response()
            ->json([
                'saved' => true,
                'message' => 'Image changed.'
            ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::user()->id)
            ->firstOrFail();

        // RecipeIngredient::where('recipe_id', $recipe->id)->delete();
        // RecipeDirection::where('recipe_id', $recipe->id)->delete();

        // File::delete(public_path('storage/'.$recipe->thumbnail));

        $course->delete();

        return response()
            ->json([
                'deleted' => true
            ]);

    }

    /**
     * Edit status of a course
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function editStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);

        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::user()->id)
            ->firstOrFail();

        $course->status = $request->status;

        $course->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $course->id,
                'status' => $course->status,
                'message' => 'Course status changed'
            ]);

    }

}
