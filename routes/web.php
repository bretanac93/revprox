<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    if (!Auth::user())
        return redirect()->to('login');
    else
        return redirect()->to('/dashboard');
});

Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

Route::resource('/proxies', 'ReverseProxyController');

Route::resource('/files', 'FileManController');

Route::get('/preferences/scripts', 'PreferencesController@scripts_index')
    ->name('preferences.scripts.index');

Route::put('/preferences/scripts', 'PreferencesController@scripts_update')
    ->name('preferences.scripts.update');

Auth::routes();
