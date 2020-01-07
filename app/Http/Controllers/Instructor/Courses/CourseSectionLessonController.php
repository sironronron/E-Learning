<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Models
use App\Models\Course\Course;
use App\Models\Course\CourseSection;
use App\Models\Course\CourseSectionLesson;

// Storage
use File;
use Storage;

// Cloud Storage
use JD\Cloudder\Facades\Cloudder;

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
            'summary' => 'required'
        ]);

        $lesson = new CourseSectionLesson($request->all());
        $lesson->slug = str_slug($request->title, '-');

        if (isset($request->thumbnail)) {
            $this->validate($request, [
                'thumbnail' => 'required|mimes:jpg,png,jpeg,webp|between:1,6000'
            ]);
            $image = $request->file('thumbnail');
            $name = $request->file('thumbnail')->getClientOriginalName();
            $image_name = $request->file('thumbnail')->getRealPath();
            Cloudder::upload($image_name, null);
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
            Cloudder::upload($file_name, array('resource_type' => 'auto'));
            list($width, $height) = getImageSize($file_name);
            $file_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
            $lesson->lesson_attachment = $file_url;
        }

        $lesson->save();

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
}
