<?php 

	Route::group(['prefix' => 'dashboard'], function(){

		// Admin Console
		Route::group(['prefix' => 'console'], function(){
			Route::resource('manage/users', 'UserController');
			Route::group(['prefix' => 'manage/users'], function(){
				Route::get('verify/{token}', 'UserController@resendVerifyEmail');
				Route::get('password/{token}/reset', 'UserController@getResetPassword');
				Route::put('suspend/{token}', 'UserController@suspendUser');
				Route::put('activate/{token}', 'UserController@activateUser');
				Route::put('password/{token}/reset', 'UserController@putResetPassword');
			});
		});

		// Settings Section
		Route::group(['prefix' => 'settings'], function(){
			Route::post('text/{id}/active', 'TextController@active');
			Route::resource('text', 'TextController');
			Route::post('lead/vendor/{id}/active', 'LeadVendorController@active');
			Route::resource('lead/vendor', 'LeadVendorController');
		});


		Route::get('/', 'DashboardController@getIndex');
		
		Route::post('enquiry/{id}/active', 'EnquiryController@active');
		Route::resource('enquiry', 'EnquiryController');
	});