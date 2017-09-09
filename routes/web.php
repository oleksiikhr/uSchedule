<?php

Auth::routes();

Route::get('/', 'DashboardController@index');
Route::post('/dashboard/find', 'DashboardController@find');

Route::get('/university', 'UniversityController@index');

Route::resource('schedule', 'ScheduleController');