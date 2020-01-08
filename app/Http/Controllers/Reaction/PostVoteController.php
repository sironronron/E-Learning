<?php

namespace App\Http\Controllers\Reaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HelpCenter\Post;
use App\Models\Reaction\PostVote;

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
        $user = $request->user();

        $reaction = new PostVote();

    }
}
