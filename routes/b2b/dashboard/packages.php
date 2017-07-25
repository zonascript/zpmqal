<?php 
	
	// using this route url like ww...com/dashboard/package/*
	/*---------------------------Package all Route---------------------------*/
	Route::get('open/{token}', 'PackageController@open')
					->name('openPackage');

	// Here all Package will show like list of package 
	Route::get('all/{token}', 'PackageController@show')
					->name('allPackage');

	Route::get('all', 'PackageController@index')
					->name('package.all');

	// this will save package cost
	Route::post('savecost/{token}', 'PackageController@saveCost')
					->name('saveCost');

	Route::post('savenote/{token}', 'PackageController@saveNote')
					->name('saveNote');

	Route::post('sendpackageemail/{token}', 'PackageController@sendPackageEmail')
					->name('sendPackageEmail');
	

	// it will generate html of a specific package
	Route::get('html/{packageDbId}', 'PackageController@getCreatePdfHtml');

	// it will generate pdf of a specific package
	Route::get('pdf/{hashId}', 'PackageController@getCreatePdf');


	// this for finding next event
	Route::get('event/{routeDbId}', 'PackageController@getEvent');
	Route::get('builder/event/{token}/{current}', 'PackageController@getFindEvent');

	Route::get('replica/{pid}', 'PackageController@makePackageRaplica');

	Route::match(['get', 'post'], 'track/json', 'TrackPackageController@getActiveJson');