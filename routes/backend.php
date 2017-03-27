<?php
	
//Backend Login
Route::get('login', 'BackendAuth\LoginController@showLoginForm');
Route::post('login', 'BackendAuth\LoginController@login');
Route::get('logout', 'BackendAuth\LoginController@logout');
Route::post('logout', 'BackendAuth\LoginController@logout');

//Backend Register
Route::get('register', 'BackendAuth\RegisterController@showRegistrationForm');
Route::post('register', 'BackendAuth\RegisterController@register');

//Backend Passwords
Route::post('password/email', 'BackendAuth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'BackendAuth\ResetPasswordController@reset');
Route::get('password/reset', 'BackendAuth\ForgotPasswordController@showLinkRequestForm');
Route::get('password/reset/{token}', 'BackendAuth\ResetPasswordController@showResetForm');


Route::get('home', 'BackendApp\PagesController@getHome');

Route::group(['middleware' => ['backend']], function(){
	Route::get('/', 'BackendApp\PagesController@getIndex');
	Route::post('image/upload', 'BackendApp\ImagesController@upload');

	Route::get('/dashboard', 'BackendApp\DashboardController@getIndex');
	
	Route::get('/dashboard/activities/all', 'BackendApp\ActivitiesController@all');

	Route::get('/dashboard/activities/destination', 'BackendApp\ActivitiesController@selectDestination');
	Route::resource('dashboard/activities', 'BackendApp\ActivitiesController');
	
	Route::post('dashboard/activities/f/{id}/rank', 'BackendApp\ActivitiesController@rank');
	Route::resource('dashboard/activities/v', 'BackendApp\ViatorActivitiesController');
	Route::post('dashboard/activities/v/{id}/rank', 'BackendApp\ViatorActivitiesController@rank');

	Route::post('/dashboard/activities/saveimage', 'BackendApp\ActivitiesController@storeImage');

	// Saving images 
	
	Route::post('/destination', 'BackendApp\DestinationController@postDestination');
	Route::post('/destination/option', 'BackendApp\DestinationController@postDestinationOption');
	
	Route::get('/destination/json', 'BackendApp\DestinationController@getDestination');

	Route::get('viator/activities/insert', 'BackendApp\ViatorActivitiesController@insertActivities');
});


Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('backend')->user();

    //dd($users);

    return view('backend.home');
})->name('home');

