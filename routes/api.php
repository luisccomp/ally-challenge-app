<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) 
{
    return $request->user();
});

Route::prefix('v1')->group(function () 
{
    Route::post('/schools', 'App\Http\Controllers\SchoolsController@createSchool');
    Route::get('/schools', 'App\Http\Controllers\SchoolsController@findAllSchools');
    Route::get('/schools/{id}', 'App\Http\Controllers\SchoolsController@findSchoolById');
    Route::put('/schools/{id}', 'App\Http\Controllers\SchoolsController@updateSchool');
    Route::delete('/schools/{id}', 'App\Http\Controllers\SchoolsController@deleteSchool');

    Route::post('/courses', 'App\Http\Controllers\CoursesController@createCourse');
    Route::get('/courses', 'App\Http\Controllers\CoursesController@findAllCourses');
    Route::get('/courses/{id}', 'App\Http\Controllers\CoursesController@findCourseById');
    Route::put('/courses/{id}', 'App\Http\Controllers\CoursesController@updateCourse');
    Route::delete('/courses/{id}', 'App\Http\Controllers\CoursesController@deleteCourse');

    Route::get('/ally-courses', 'App\Http\Controllers\AllyCourseController@getCoursePrices');
});
