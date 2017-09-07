<?php

Auth::routes();

Route::get('/', 'DashboardController@index');
Route::post('/dashboard/find', 'DashboardController@find');

Route::resource('schedule', 'ScheduleController');

Route::resource('teachers', 'MyBreadController');

Route::resource('subjects', 'MyBreadController');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
