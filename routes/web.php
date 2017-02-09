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

use Symfony\Component\Process\Process;

Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

Route::resource('/proxies', 'ReverseProxyController');

 Route::get('/file', function () {

     $p = new Process('touch /etc/nginx/sites-available/proxy_other');
     $p->run(function ($type, $buffer) {
         if ($type === 'err') {
             echo 'ERR > '.$buffer;
         }
         else {
             echo 'OUT > '.$buffer;
         }
     });

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


 });

Auth::routes();
