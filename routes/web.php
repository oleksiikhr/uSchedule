<?php

Route::get('/', 'Controller@index');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
