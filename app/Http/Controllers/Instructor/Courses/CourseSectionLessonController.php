<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Models
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;
use App\Models\Course\CourseUserProgress;
use App\Models\Cart\Subscription\CourseStudent;

// Storage
use File;
use Storage;

// Cloud Storage
use JD\Cloudder\Facades\Cloudder;

// Authenticated
use Auth;

// Carbon
use Carbon\Carbon;

class CourseSectionLessonController extends Controller
{

    /**
     * Show and return needed data for each lesson
     *
     * @param $course_id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $course = Course::where('id', $id)
            ->firstOrFail(['id']);

        $sections = CourseSection::where('course_id', $course->id)
            ->get(['id', 'title']);

        return response()
            ->json([
                'sections' => $sections
            ]);

    }

    /**
     * Create a lesson on each section
     *
     * @return Illuminate\Http\Response
     * @return Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'lesson_type' => 'required',
        ]);

        $lesson = new CourseSectionLesson($request->all());

        $lesson->slug = str_slug($request->title, '-');

        $section = CourseSection::find($request->course_section_id);

        $time = $request->duration;
        $time2 = $section->total_duration;

        $secs = strtotime($time2) - strtotime("00:00:00");
        $result = gmdate("H:i:s", strtotime($time) + $secs);

        $section->total_duration = $result;
        $section->save();

        if (isset($request->thumbnail)) {
            $this->validate($request, [
                'thumbnail' => 'required|mimes:jpg,png,jpeg,webp|between:1,6000'
            ]);
            $image = $request->file('thumbnail');
            $name = $request->file('thumbnail')->getClientOriginalName();
            $image_name = $request->file('thumbnail')->getRealPath();
            Cloudder::upload($image_name, null, ['folder' => 'Lesson Thumbnails']);
            list($width, $height) = getImageSize($image_name);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
            $lesson->thumbnail = $image_url;
        }

        if (isset($request->lesson_attachment)) {
            $this->validate($request, [
                'lesson_attachment' => 'required|mimes:txt,pdf,docx,jpg,jpeg,png,webp'
            ]);
            $file = $request->file('lesson_attachment');
            $name = $request->file('lesson_attachment')->getClientOriginalName();
            $file_name = $request->file('lesson_attachment')->getRealPath();
            Cloudder::upload($file_name, null, array('resource_type' => 'auto', 'folder' => 'Lesson Attachments'));
            $file_url = Cloudder::getPublicId(['resource_type' => 'auto']);
            $lesson->lesson_attachment = $file_url;
        }

        if ($request->lesson_provider == 'HTML5') {
            $this->validate($request, [
                'video_url' => 'required|mimes:mp4'
            ]);

            Cloudder::uploadVideo($request->video_url, null, array('folder' => 'Lesson Videos'));
            $file_url = Cloudder::show(Cloudder::getPublicId(), ['resource_type' => 'video', 'format' => 'mp4']);
            $lesson->video_url = $file_url;
            $lesson->video_html5_public_id = Cloudder::getPublicId();
        }

        $lesson->save();

        $courseUserProgress = CourseUserProgress::where('lesson_id', $lesson->id)
            ->first();

        if (!$courseUserProgress) {

            $user = Auth::user();

            $courseStudents = Course::where('id', $request->course_id)
                ->first();

            $studentId = CourseStudent::where('user_id', $user->id)
                ->where('course_id', $courseStudents->id)
                ->first();

            if ($studentId) {
                $time = $studentId->total_time;
                $time2 = $lesson->duration;

                $secs = strtotime($time2) - strtotime("00:00:00");
                $result = date("H:i:s", strtotime($time) + $secs);

                $studentId->total_time = $result;

                $studentId->save();
            }


            foreach ($courseStudents->students() as $student) {
                $userProgress = new CourseUserProgress();

    			$userProgress->course_id = $request->course_id;
    			$userProgress->user_id = $user->id;
                $userProgress->section_id = $lesson->course_section_id;
    			$userProgress->lesson_id = $lesson->id;
    			$userProgress->status = 0;

    			$userProgress->save();
            }
        }


        return response()
            ->json([
                'saved' => true,
                'course_section_id' => $lesson->course_section_id,
                'id' => $lesson->id,
                'lesson_attachment' => $lesson->lesson_attachment,
                'lesson_image' => $lesson->lesson_image,
                'lesson_provider' => $lesson->lesson_provider,
                'lesson_type' => $lesson->lesson_type,
                'summary' => $lesson->summary,
                'title' => $lesson->title,
                'message' => 'Lesson successfully added!',
                'duration' => $lesson->duration
            ]);

    }

    /**
     * Get Data for editting
     *
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $lesson = CourseSectionLesson::where('id', $id)
            ->firstOrFail();

        return response()
            ->json([
                'lesson' => $lesson
            ]);
    }

    /**
     * Update Lesson Data
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'lesson_type' => 'required',
        ]);

        $lesson = CourseSectionLesson::find($id);

        $input = $request->all();
        $lesson->fill($input);

        $lesson->save();

        return response()
            ->json([
                'updated' => true,
                'lesson' => $lesson,
                'message' => "Lesson is updated"
            ]);
    }

    /**
     * Delete Lessons
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function destroy($id)
    {
        $lesson = CourseSectionLesson::where('id', $id)
            ->firstOrFail();

        CourseUserProgress::where('lesson_id', $id)->delete();

        $lesson->delete();

        return response()
            ->json([
                'deleted' => true,
                'message' => "Lesson deleted successfully $lesson->title"
            ]);
    }


    /**
     * Update order_index of Lessons
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
    */
    public function updateOrderIndex(Request $request, $id)
    {
        $this->validate($request, [
            'lessons.*.order_index' => 'required'
        ]);

        $lessons = CourseSectionLesson::all();

        foreach ($lessons as $lesson) {
            $id = $lesson->id;
            foreach ($request->lessons as $lesson) {
                CourseSectionLesson::find($lesson['id'])->update(['order_index' => $lesson['order_index']]);
            }
        }

        return response()
            ->json([
                'saved' => true,
                'message' => 'Lesson Order Changed'
            ], 200);
    }
}
