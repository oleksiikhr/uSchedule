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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/teachers', 'TeacherController@index');

Route::group(['prefix' => 'teachers'], function ($router) {
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