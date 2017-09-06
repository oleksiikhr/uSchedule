<?php

Auth::routes();

Route::get('/', 'DashboardController@index');
Route::post('/dashboard/find', 'DashboardController@find');

Route::resource('schedule', 'ScheduleController');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
