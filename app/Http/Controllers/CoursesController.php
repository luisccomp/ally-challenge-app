<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\School;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    /**
     * Validate course and store it on database (if school exists).
     */
    public function createCourse(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => DateTime::createFromFormat('Y-m-d', $request->input('start_date')),
            'school_id' => intval($request->input('school_id'))
        ];

        $validator = $this->validateRequestData($data);

        if ($validator->fails())
        {
            return response([
                'status' => 400,
                'message' => 'Invalid field value(s)',
                'details' => $validator->errors()
            ], 400);
        }

        try
        {
            School::findOrFail($data['school_id']);
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'School not found',
                'details' => null
            ], 404);
        }

        $course = new Course;

        $course->name = $data['name'];
        $course->description = $data['description'];
        $course->start_date = $data['start_date'];
        $course->school_id = $data['school_id'];
        $course->created_at = new DateTime;
        $course->updated_at = new DateTime;

        $course->save();

        return response($course, status: 201);
    }

    /**
     * Find all courses stored on database
     */
    public function findAllCourses(Request $request)
    {
        return Course::with('school')->get();
    }

    /**
     * Get a course by id if exists
     */
    public function findCourseById(Request $request)
    {
        $id = intval($request->route('id'));

        try
        {
            return Course::with('school')->findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'Course not found',
                'details' => null
            ], 404);
        }
    }

    /**
     * Update course details
     */
    public function updateCourse(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => DateTime::createFromFormat('Y-m-d', $request->input('start_date')),
            'school_id' => intval($request->input('school_id'))
        ];

        $validator = $this->validateRequestData($data);

        if ($validator->fails())
        {
            return response([
                'status' => 400,
                'message' => 'Invalid field value(s)',
                'details' => $validator->errors()
            ], 400);
        }

        $id = intval($request->route('id'));

        try
        {
            $course = Course::findOrFail($id);
            
            $course->name = $data['name'];
            $course->description = $data['description'];
            $course->start_date = $data['start_date'];
            $course->school_id = $data['school_id'];
            $course->updated_at = new DateTime;

            $course->save();

            return $course;
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'Course not found',
                'details' => null
            ], 404);
        }
    }

    /**
     * Delete a course if exists
     */
    public function deleteCourse(Request $request)
    {
        $id = intval($request->route('id'));

        try
        {
            Course::findOrFail($id)->delete();

            return response(status: 204);
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'Course not found',
                'details' => null
            ], 404);
        }
    }

    private function validateRequestData($data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'start_date' => 'required',
            'school_id' => 'required'
        ]);
    }
}
