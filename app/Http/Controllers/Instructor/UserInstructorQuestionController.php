<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User\UserInstructorQuestion;
use App\User;

class UserInstructorQuestionController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }
    /**
     * Store User Instructor Questions
     * 
     * @return Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'teaching_skills' => 'required',
            'video_skills' => 'required',
            'audience_number' => 'required'
        ]);

        $user = $request->user();

        $uiQuestion = new UserInstructorQuestion();

        $request->user()
            ->userInstructorQuestion()->save($uiQuestion);

        $user->role_id = 3;

        $user->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $uiQuestion->id,
                'message' => 'Congratulations! You can now post your courses.',
                'role_id' => $user->role_id
            ]);
    }
}
