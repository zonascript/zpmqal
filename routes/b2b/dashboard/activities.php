<?php 

	Route::get('dashboard/activities/search/{id}', 'ActivitiesController@searchActivities');
	Route::post('dashboard/hotel/find/uni/{id}', 'ActivitiesController@findActivity');


	Route::get('dashboard/package/builder/activities/{packageDbId}', 'ActivitiesController@getActivitiesByPackageId');
	Route::post('dashboard/package/builder/activities/{packageDbId}', 'ActivitiesController@postActivities');
	
	Route::post('dashboard/package/builder/activities/save/{id}', 'ActivitiesController@saveActivities');


	Route::get('uni/activities/result/{id}', 'ActivitiesController@postUnionActivitiesResult');
	Route::post('uni/activities/result/{id}', 'ActivitiesController@postUnionActivitiesResult');
	Route::get('uni/activities/result/{id}/sel', 'ActivitiesController@postSelectedActivities');
	Route::post('uni/activities/result/{id}/sel', 'ActivitiesController@postSelectedActivities');
	// Route::get('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');
	// Route::post('fgf/activities/result/{id}', 'ActivitiesController@postFgfActivitiesResult');
	// Route::post('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');

	Route::get('dashboard/test/activities/', 'Api\ActivityController@all');
	Route::get('scrape/data/activities', 'Api\ScrapeController@expedia');
	

	Route::get('dashboard/data/viator/product', 'Api\ViatorController@fatchProductByDestination');
	Route::get('dashboard/data/viator/product/detail', 'Api\ViatorController@fatchProductDetail');



