<?php

// Auth
Route::post('/login', 'AuthController@login')->middleware('guest');

// Public
Route::get('subjects', 'Api\SubjectController@list');

// Private
Route::group(['middleware' => 'jwt.auth'], function () {

    // TODO: User is auth

    // Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@index');
    });

});
