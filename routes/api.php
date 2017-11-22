<?php

// Auth
Route::post('/login', 'AuthController@login')->middleware('guest');
Route::get('/refresh-token', 'AuthController@refreshToken')->middleware('guest');

// Public
// TODO: temporary&
Route::get('/schedules/{id}', 'ScheduleController@one')->where('id', '[0-9]+');
Route::get('/subjects', 'SubjectController@list');
Route::get('/teachers', 'TeacherController@list');

// Private
Route::group(['middleware' => 'jwt.auth'], function () {

    // Note: User is auth

    Route::post('/logout', 'AuthController@logout');

    // Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@index');
    });

});
