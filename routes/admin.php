<?php

Route::get('login', 'AdminAuth\LoginController@showLoginForm');
Route::post('login', 'AdminAuth\LoginController@login');
Route::post('logout', 'AdminAuth\LoginController@logout');

Route::get('register', 'AdminAuth\RegisterController@showRegistrationForm');
Route::post('register', 'AdminAuth\RegisterController@register');

Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset');
Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

Route::get('home', 'AdminApp\PagesController@getHome');

Route::group(['middleware' => ['admin']], function(){
	
	Route::get('/', 'AdminApp\PagesController@getIndex');
	Route::get('/dashboard', 'AdminApp\DashboardController@getIndex');

	Route::resource('/dashboard/enquiry', 'AdminApp\EnquiryController');
	Route::post('/dashboard/enquiry/{id}/active', 'AdminApp\EnquiryController@active');

	// Settings Section
	Route::resource('/dashboard/settings/text', 'AdminApp\TextController');
	Route::post('/dashboard/settings/text/{id}/active', 'AdminApp\TextController@active');

	Route::resource('/dashboard/settings/lead/vendor', 'AdminApp\LeadVendorController');
	Route::post('/dashboard/settings/lead/vendor/{id}/active', 'AdminApp\LeadVendorController@active');
});


Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');

