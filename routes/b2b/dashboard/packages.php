<?php 
	
	// using this route url like ww...com/dashboard/package/*
	/*---------------------------Package all Route---------------------------*/
	Route::get('open/{token}', 'PackageController@open');

	// Here all Package will show like list of package 
	Route::get('all/{id}', 'PackageController@index');
	
	// this will save package cost
	Route::post('savecost/{id}/{packageDbId}', 'PackageController@saveCost');
	
	// it will generate html of a specific package
	Route::get('html/{packageDbId}', 'PackageController@getCreatePdfHtml');

	// it will generate pdf of a specific package
	Route::get('pdf/{hashId}', 'PackageController@getCreatePdf');

	/*-------------------New enquiry creation will oprate here-------------------*/
	// this route is gui to get information
	Route::get('create/{id}', 'PackageBuilderController@create');
	// this route will store the information into DB
	Route::post('create/{id}', 'PackageBuilderController@store');

	// this for finding next event
	Route::get('event/{routeDbId}', 'PackageController@getEvent');
	Route::get('builder/event/{token}/{current}', 'PackageController@getFindEvent');