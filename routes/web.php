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

Route::get('/sites_per_file', 'HomeController@sites_per_file');
Route::get('/online_users', 'HomeController@online_users');
// Route::get('/latest_operations', 'HomeController@latest_operations');

Route::get('/', function () {
    if (!Auth::user())
        return redirect()->to('login');
    else
        return redirect()->to('/dashboard');
});

Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

Route::resource('/proxies', 'ReverseProxyController');

Route::resource('/files', 'FileManController');

Route::get('/access_logs', 'AccessLogController@index')
    ->name('admin.access_log.index');

Route::get('/preferences/scripts', 'PreferencesController@scripts_index')
    ->name('preferences.scripts.index');

Route::put('/preferences/scripts', 'PreferencesController@scripts_update')
    ->name('preferences.scripts.update');

Route::get('/preferences/nginx_routes', 'PreferencesController@routes_index')
    ->name('preferences.routes.index');

Route::get('/preferences/nginx_routes/create', 'PreferencesController@routes_create')
    ->name('preferences.routes.create');

Route::post('/preferences/nginx_routes', 'PreferencesController@routes_store')
    ->name('preferences.routes.store');

Route::get('/preferences/nginx_routes/{id}', 'PreferencesController@routes_edit')
    ->name('preferences.routes.download');

Route::put('/preferences/nginx_routes/{id}/update', 'PreferencesController@routes_update')
    ->name('preferences.routes.upload');

Route::delete('/preferences/nginx_routes/{id}', 'PreferencesController@routes_remove')
    ->name('preferences.routes.delete');

Route::get('/ajax/bak/{filename}', 'PreferencesController@check_bak');

Auth::routes();

Route::get('/register', function () {
    return redirect()->to('/login');
});
