<?php 

	Route::group(['prefix' => 'dashboard/package/builder/activities'], function () {
		Route::get('{token}', 'ActivitiesController@getActivitiesByToken');
		Route::post('add/{routeId}', 'ActivitiesController@postAddActivity');
		Route::post('remove/{routeId}', 'ActivitiesController@postRemoveActivity');
	});

	Route::group(['prefix' => 'api/package/activities'], function () {
		Route::any('fatch/{rid}', 'ActivitiesController@postFatchActivities');
		Route::get('names/{rid}','ActivitiesController@getActivityNames');
		Route::any('search/{rid}','ActivitiesController@postActivitiesSearch');
	});





/*
	Route::get('dashboard/activities/search/{id}', 'ActivitiesController@searchActivities');
	Route::post('dashboard/Activities/find/uni/{id}', 'ActivitiesController@findActivity');


	Route::get('dashboard/package/builder/activities/{packageDbId}', 'ActivitiesController@getActivitiesByPackageId');
	Route::post('dashboard/package/builder/activities/{packageDbId}', 'ActivitiesController@postActivities');
	
	Route::post('dashboard/package/builder/activities/save/{id}', 'ActivitiesController@saveActivities');


	Route::get('uni/activities/result/{id}', 'ActivitiesController@postUnionActivitiesResult');
	Route::post('uni/activities/result/{id}', 'ActivitiesController@postUnionActivitiesResult');
	// Route::get('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');
	// Route::post('fgf/activities/result/{id}', 'ActivitiesController@postFgfActivitiesResult');
	// Route::post('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');

	/*Route::get('dashboard/test/activities/', 'Api\ActivityController@all');
	Route::get('scrape/data/activities', 'Api\ScrapeController@expedia');
	

	Route::get('dashboard/data/viator/product', 'Api\ViatorController@fatchProductByDestination');
	Route::get('dashboard/data/viator/product/detail', 'Api\ViatorController@fatchProductDetail');*/



