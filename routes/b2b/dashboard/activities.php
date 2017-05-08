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
	// Route::get('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');
	// Route::post('fgf/activities/result/{id}', 'ActivitiesController@postFgfActivitiesResult');
	// Route::post('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');

	//Route::get('scrape/data/activities', 'Api\ScrapeController@expedia');
*/
