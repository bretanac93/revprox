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
    return view('welcome');
});

Route::resource('/admin/reverseproxy', 'Admin\\ReverseProxyCrudController');

// Route::get('/file', function () {
// 	$HOME_ROOT = "/home/bretanac93";
	
//     shell_exec("cat /var/log/nginx/error.log | grep emerg > $HOME_ROOT/filtered.log");
    
//     if (file_exists("$HOME_ROOT/filtered.log")) {
    	
//     	$file = fopen("$HOME_ROOT/filtered.log", 'r');
//     	$a = [];
//     	while ($line = fgets($file)) {
//     		$a[] = $line;
//     	}
//     	shell_exec("rm -f $HOME_ROOT/filtered.log");
//     	dd($a);

//     } else {
//     	dd("File not found");
    	
//     }


// });
