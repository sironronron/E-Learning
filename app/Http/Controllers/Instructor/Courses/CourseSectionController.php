<?php

namespace App\Http\Controllers\Instructor\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Course Model
use App\Models\Course\Course;
use App\Models\Course\CourseSection;

class CourseSectionController extends Controller
{
    /**
     * Create new section in courses
     *
     * @param int id // Course ID
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);

        $course = Course::where('id', $id)
            ->firstOrFail();

        $section = new CourseSection($request->all());
        $section->slug = str_slug($request->title, '-');
        $section->course_id = $course->id;
        $section->order_index++;

        $section->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $section->id,
                'title' => $section->title,
                'slug' => $section->slug,
                'message' => "Section succesfully saved!"
            ]);
    }

    /**
     * Get data for editting
     *
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $section = CourseSection::find($id);

        return response()
            ->json([
                'section' => $section
            ]);
    }

    /**
     * Update section
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);

        $section = CourseSection::where('id', $id)
            ->firstOrFail();

        $input = $request->all();
        $section->fill($input);

        $section->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $section->id,
                'message' => "Section #$section->id, updated succesfully",
                'section' => $section
            ]);
    }

    /**
     * Delete Section
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = CourseSection::where('id', $id)
            ->firstOrFail();

        $section->delete();
    }

    /**
     *  Update order_index of Section
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function updateOrderIndex(Request $request, $id)
    {
        $this->validate($request, [
            'sections.*.order_index' => 'required'
        ]);

        $sections = CourseSection::all();

        foreach($sections as $section) {
            $id = $section->id;
            foreach ($request->sections as $section) {
                CourseSection::find($section['id'])->update(['order_index' => $section['order_index']]);
            }
        }

        return response()
            ->json([
                'saved' => true,
                'message' => 'Order changed'
            ], 200);

    }
}
