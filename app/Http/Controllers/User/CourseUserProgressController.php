<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Auth
use Auth;

// Course MOdels
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;
use App\Models\Course\CourseUserProgress;

use App\Models\Cart\Subscription\CourseStudent;

class CourseUserProgressController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    /**
     * Update Course User Progress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $this->validate($request, [
            'status' => 'required'
        ]);

        $lessonDuration = CourseSectionLesson::where('id', $id)
            ->where('duration', '!=', null)
            ->first();

        $lesson = CourseUserProgress::where('lesson_id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $studentCourse = CourseStudent::where('course_id', $lesson->course_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($lessonDuration != null) {
            $start = $lessonDuration->duration; 
            $end = $studentCourse->total_time;
            $total = strtotime($end) - strtotime($start);
            $time = gmdate("H:i:s", $total);
            $studentCourse->total_time = $time;
            $studentCourse->save();
        }

        $lesson->status = 1;
        $lesson->update();

        return response()
            ->json([
                'saved' => true,
                'message' => 'Lesson Progress Saved',
                'id' => $lesson->id,
                'status' => $lesson->status
            ]);
    }
}
