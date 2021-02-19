<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Schools controller: this controller provides schools model integration.
 */
class SchoolsController extends Controller
{
    /**
     * Create a school and store it on database after validate request. If request
     * is not valid, then return status 400.
     */
    public function createSchool(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'city' => $request->input('city')
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

        $school = new School;
        $school->name = $data['name'];
        $school->city = $data['city'];
        $school->created_at = new DateTime;
        $school->updated_at = new DateTime;

        $school->save();

        return response([
            'id' => $school->id,
            'name' => $school->name,
            'city' => $school->city
        ], 201);
    }

    /**
     * Find a list with all schools registered.
     */
    public function findAllSchools(Request $reques)
    {
        return School::all(['id', 'name', 'city']);
    }

    /**
     * Find a school given it's ID
     */
    public function findSchoolById(Request $reques)
    {
        $id = intval($reques->route('id'));

        try
        {
            $school = School::findOrFail($id);

            return [
                'id' => $school->id,
                'name' => $school->name,
                'city' => $school->city
            ];
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'School not found',
                'details' => null
            ], 404);
        }
    }

    /**
     * Updates school information.
     */
    public function updateSchool(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'city' => $request->input('city')
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
            $school = School::findOrFail($id);

            $school->name = $data['name'];
            $school->city = $data['city'];
            $school->updated_at = new DateTime;

            $school->save();

            return [
                'id' => $school->id,
                'name' => $school->name,
                'city' => $school->city
            ];
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'School not found',
                'details' => null
            ], 404);
        }
    }

    /**
     * Delete a school.
     */
    public function deleteSchool(Request $request)
    {
        $id = intval($request->route('id'));

        try
        {
            $school = School::findOrFail($id);

            $school->delete();

            return response(status:204);
        }
        catch (ModelNotFoundException $e)
        {
            return response([
                'status' => 404,
                'message' => 'School not found',
                'details' => null
            ], 404);
        }
    }

    private function validateRequestData(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'city' => 'required|max:255'
        ]);
    }
}
