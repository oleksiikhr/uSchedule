<?php

Auth::routes();

Route::get('/', 'DashboardController@index');

Route::resource('schedule', 'ScheduleController');