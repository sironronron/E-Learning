<?php

namespace App\Http\Controllers\Reaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HelpCenter\Post;
use App\Models\Reaction\PostVote;

use Auth;

class PostVoteController extends Controller
{
    /**
     * Applies middleware to controller
     * 
     */
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    /**
     * Store Like/Dislike
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $vote = new PostVote();

        $vote->user_id = Auth::user()->id;
        $vote->post_id = $request->post_id;
        $vote->vote = 'LIKED';

        $vote->save();

        return response()
            ->json([
                'liked' => true,
                'message' => "You liked this post?"
            ]);
    }

    /**
     * Update Like/Dislike
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
        //
    }

}
