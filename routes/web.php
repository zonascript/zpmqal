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

include('common.php');

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

Route::group(['domain' => env('ITINERARY_DOMAIN')], function () {
	include('itinerary.php');
});

if (env('IS_LOCALHOST')) {
	include('temp.php');
}