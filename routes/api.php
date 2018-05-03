<?php

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['prefix' => 'teachers'], function () {
    Route::get('/', 'TeacherController@index');
    Route::get('{id}', 'TeacherController@show');

    // TODO middleware -> is_admin === 1
    Route::group(['middleware' => 'api'], function () {
        Route::post('/', 'TeacherController@store');
        Route::patch('{id}', 'TeacherController@update');
        Route::delete('{id}', 'TeacherController@destroy');
    });
});

Route::group(['prefix' => 'subjects'], function () {
    Route::get('/', 'SubjectController@index');
    Route::get('{id}', 'SubjectController@show');

    // TODO middleware -> is_admin === 1
    Route::group(['middleware' => 'api'], function () {
        Route::post('/', 'SubjectController@store');
        Route::patch('{id}', 'SubjectController@update');
        Route::delete('{id}', 'SubjectController@destroy');
    });
});
