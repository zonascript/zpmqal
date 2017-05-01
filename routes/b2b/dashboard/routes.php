<?php 
/*-------------------------New enquiry creation will-------------------------*/
	// this route is to create package 
	// Route::get('{id}/n', 'RouteController@createPackage');
	
	// this route is gui to get information
	Route::group(['prefix' => 'route'], function () {
		Route::get('{id}/{token?}', 'RouteController@create');
		Route::post('{id}/r', 'RouteController@storeRow');
		Route::post('{id}/d', 'RouteController@deleteRow');
		Route::post('{id}/u', 'RouteController@packageUpdate');

		// this route will store the information into DB
		Route::post('{id}/', 'RouteController@store');

		// this will update route in db only origin and destination
		Route::post('update/{id}', 'RouteController@updateRoute');
	});
