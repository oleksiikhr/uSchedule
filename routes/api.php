<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/teachers', 'TeacherController@index');
Route::get('/{id}', 'TeacherController@show');

Route::group(['middleware' => 'api', 'prefix' => 'teachers'], function ($router) {
    Route::post('/', 'TeacherController@store');
    Route::patch('/{id}', 'TeacherController@update');
    Route::delete('/{id}', 'TeacherController@destroy');
});

Route::get('/subjects', 'SubjectController@index');

Route::group(['prefix' => 'subjects'], function ($router) {
    Route::post('/', 'SubjectController@store');
    Route::patch('/{id}', 'SubjectController@update');
    Route::delete('/{id}', 'SubjectController@destroy');
});