<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Auth
use Auth;

// Course Models
use App\Models\Course\Course;
use App\Models\Course\CourseRating;
use Psy\Command\ListCommand\FunctionEnumerator;

class CourseRatingController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    /**
     *
     * Get all ratings of acourse
     */
    public function index()
    {
    	// Code here
    }

    /**
     *
     * Store new rating for course
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'rating' => 'required|min:1|max:5'
    	]);

    	$rating = new CourseRating($request->all());

        $rating->teach_id = $request->teacher_id;

    	$request->user()
    		->reviews()->save($rating);

    	return response()
    		->json([
    			'saved' => true,

                // Push new values
                'id' => $rating->id,
                'user_id' => $rating->user_id,
                'course_id' => $rating->course_id,
                'teacher_id' => $rating->teacher_id,
                'rating' => $rating->rating,
                'comments' => $rating->comments,
                'created_at' => $rating->created_at,
                'updated_at' => $rating->updated_at,

    			'message' => "Rating successfully submitted! Thank you for making time for this.",
    		]);
    }

    /**
     * Update Rating
     *
     */
    public function edit($id)
    {
        $rating = CourseRating::find($id);

        return response()
            ->json([
                'rating' => $rating
            ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
    		'rating' => 'required|min:1|max:5'
        ]);

        $rating = CourseRating::where('id', $id)
            ->firstOrFail();

        $input = $request->all();
        $rating->fill($input);

        $rating->save();

        return response()
            ->json([
                'updated' => true,
                'rating' => $rating,
                'message' => 'Rating updated'
            ]);
    }

}
