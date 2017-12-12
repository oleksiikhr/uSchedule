<?php

/* | -------------------------------------------------------------------
 * | User is not logged in.
 * | -------------------------------------------------------------------
 */
Route::group(['middleware' => 'guest'], function () {

    /** @see \App\Http\Controllers\AuthController - Auth Section */
    Route::post('register', 'AuthController@register'); // TODO: make (email, password, object_id)
    Route::post('login', 'AuthController@login');
    Route::post('restore-password', 'AuthController@restorePassword'); // TODO: write this method
    Route::get('refresh-token', 'AuthController@refreshToken');

});

/* | -------------------------------------------------------------------
 * | User authorized.
 * | -------------------------------------------------------------------
 */
Route::group(['middleware' => 'jwt.auth'], function () {

    Route::post('logout', 'AuthController@logout');

    /** @see \App\Http\Controllers\ProfileController - Profile Section */
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@index');
    });

    /** @see \App\Http\Controllers\ObjectController - Object Section */
    Route::group(['prefix' => 'object'], function () {
        Route::get('{id}', 'ObjectController@one');
        Route::post('/create', 'ObjectController@create');
        Route::put('/{id}', 'ObjectController@update');
        Route::delete('/{id}', 'ObjectController@delete');
    });

    Route::group(['prefix' => 'subject'], function () {
        Route::get('/list', 'SubjectController@list');
    });

    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/list', 'TeacherController@list');
    });

});

/* | -------------------------------------------------------------------
 * | Public methods.
 * | -------------------------------------------------------------------
 */
Route::get('objects', 'ObjectController@list');
Route::get('schedules', 'ScheduleController@list');
Route::get('schedules/days', 'ScheduleController@days');
Route::get('subjects', 'SubjectController@list');
Route::get('teachers', 'TeacherController@list');
