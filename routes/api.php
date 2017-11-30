<?php

/*
 * User is not logged in.
 */
Route::group(['middleware' => 'guest'], function () {

    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::get('/refresh-token', 'AuthController@refreshToken');

});

/*
 * User authorized.
 */
Route::group(['middleware' => 'jwt.auth'], function () {

    Route::post('/logout', 'AuthController@logout');

    // Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@index');
    });

});

/*
 * Public.
 */
Route::get('/schedules', 'ScheduleController@one');
Route::get('/schedules/days', 'ScheduleController@days');
Route::get('/subjects', 'SubjectController@list');
Route::get('/teachers', 'TeacherController@list');
