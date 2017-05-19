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

Route::group(['middleware' => ['admin'], 'namespace' => 'AdminApp'], function(){
	Route::get('/', 'PagesController@getIndex');

	Route::group(['prefix' => 'agent'], function(){
		/** @credits */
		Route::get('credits', 'PackageController@getShowPlans')
					 ->name('getCredits');
		Route::get('credits_checkout', 'PackageController@getCheckout')
					 ->name('creditsCheckout');
		Route::get('show/invoice/{txnid}', 'PackageController@showInvoice')
					 ->name('showInvoice');	

		/** @payments */
		Route::get('pay', 'PayumoneyController@pay')->name('pay');
		Route::match(['get', 'post'], 'pay/success','PayumoneyController@success')
					 ->name('paySuccess');
		Route::match(['get', 'post'], 'pay/failure', 'PayumoneyController@failure')
					 ->name('payFailure');
	});

	Route::group(['prefix' => 'dashboard'], function(){

		Route::get('/', 'DashboardController@getIndex');
		Route::resource('enquiry', 'EnquiryController');
		Route::post('enquiry/{id}/active', 'EnquiryController@active');

		// Settings Section
		Route::group(['prefix' => 'settings'], function(){
			Route::resource('text', 'TextController');
			Route::post('text/{id}/active', 'TextController@active');
			Route::resource('lead/vendor', 'LeadVendorController');
			Route::post('lead/vendor/{id}/active', 'LeadVendorController@active');
		});

	});
});


Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');

