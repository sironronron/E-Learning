<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Auth
use Auth;

// Courses
use App\Models\Course\Course;
use App\Models\Course\CourseAnnouncement;

class CourseAnnouncementController extends Controller
{
	public function __construct()
	{
		return $this->middleware('auth:api');
	}

    /**
     * Get all Announcements
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
    	$course = Course::where('slug', $slug)
    		->firstOrFail();

    	$announcements = CourseAnnouncement::where('course_id', $course->id)
    		->with(['user'])
    		->get();

    	return response()
    		->json([
    			'announcements' => $announcements,
    			'courseTeacher' => $course->teacher_id
    		]);
    }

    /**
     * Save new announcement
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request, $slug)
    {
    	$user = Auth::user();

    	$this->validate($request, [
    		'title' => 'required|max:255',
    		'description' => 'required'
    	]);

    	$course = Course::where('slug', $slug)
    		->firstOrFail();

    	$announcement = new CourseAnnouncement($request->all());

    	$announcement->course_id = $course->id;

    	$request->user()
    		->announcement()->save($announcement);

    	return response()
    		->json([
    			'saved' => true,
    			'id' => $announcement->id,
    			'message' => "Your announcement to $course->title, is posted!",
    			'newValue' => $announcement,
    			'user' => $user
    		]);
    }

    /**
     * Edit announcement
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$announcement = CourseAnnouncement::where('id', $id)
    		->where('user_id', Auth::user()->id)
    		->firstOrFail();

    	return response()
    		->json([
    			'announcement' => $announcement
    		], 200);
    }
    	
}
