<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course
use App\Models\Course\Course;
use App\Models\Course\CourseQANDA;

// Auth
use Auth;

class CourseQandAController extends Controller
{
	public function __construct() 
	{
		return $this->middleware('auth:api');
	}

    /**
     * Save new question
     *
     * @return \Illuminate\Http\Response
     */
   	public function store(Request $request) {

   		$this->validate($request, [
   			'title' => 'required|max:255',
   			'details' => 'required'
   		]);

   		$qna = new CourseQANDA($request->all());

   		$request->user()
   			->qnas()->save($qna);

   		return response()
   			->json([
   				'saved' => true,
   				'id' => $qna->id,
   				'message' => 'Question is posted.',
   				'newValue' => $qna,
   				'user' => $qna->user
   			]);
   	}

    /**
     * Reply to Course Question
     *
     * @return \Illuminate\Http\Response
     */
    public function showReplies($id)
    {
      $qna = CourseQANDA::where('id', $id)
        ->with(['user'])
        ->firstOrFail();

      $replies = CourseQANDA::where('parent_id', $qna->id)
        ->with(['user'])
        ->get();

      return response()
        ->json([
          'qna' => $qna,
          'replies' => $replies
        ]);
    }

    /**
     * Save Reply
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function reply(Request $request, $id)
    {
      $this->validate($request, [
        'details' => 'required'
      ]);

      $question = CourseQANDA::where('id', $id)
        ->firstOrFail();

      $reply = new CourseQANDA($request->all());

      $reply->parent_id = $question->id;
      $reply->course_id = $question->course_id;

      $request->user()
        ->qnas()->save($reply);

      return response()
        ->json([
          'saved' => true,
          'id' => $reply->id,
          'message' => 'Reply is posted.',
          'newValue' => $reply,
          'user' => $reply->user
        ]);
    }

  public function markAsAnswered($id)
  {
    $qna = CourseQANDA::where('id', $id)
      ->firstOrFail();

    $qna->answered = 1;

    $qna->save();

    return response()
      ->json([
        'saved' => true,
        'message' => 'Question is answered'
      ]);
  }
}
