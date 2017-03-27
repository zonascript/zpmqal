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


Route::get('/test/run', 'TestController@test');
Route::get('show-duplicate', 'ShowDuplicate@show');
Route::get('show-delete-duplicate', 'ShowDuplicate@delete');


	
//==================================server==================================
Route::group(['domain' => env('B2B_DOMAIN')], function () {
	include('b2b.php');
});

Route::group(['domain' => env('BACKEND_DOMAIN')], function () {
	include('backend.php');
});

Route::group(['domain' => env('ADMIN_DOMAIN')], function () {
	include('admin.php');
});



//==================================local==================================
Route::group(['domain' => env('LOCAL_B2B_DOMAIN')], function () {
	include('b2b.php');
});

Route::group(['domain' => env('LOCAL_BACKEND_DOMAIN')], function () {
	include('backend.php');
});

Route::group(['domain' => env('LOCAL_ADMIN_DOMAIN')], function () {
	include('admin.php');
});


// if (in_array(url('/'), [env('B2B_URL'), env('TEST_URL'), env('LOCAL_B2B_URL')])) {
// 	include('b2b.php');
// }
// elseif (in_array(url('/'),[env('BACKEND_URL'), env('LOCAL_BACKEND_URL')])) {
// 	include('backend.php');
// }
// elseif (in_array(url('/'),[env('ADMIN_URL'), env('LOCAL_ADMIN_URL')])) {
// 	include('admin.php');
// }





