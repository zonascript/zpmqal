<?php 

	Route::post('todo/status', 'ToDoController@status');
	Route::post('todo/remove', 'ToDoController@remove');
	Route::post('todo/all/json', 'ToDoController@postAllJson');
	Route::post('todo/all/html', 'ToDoController@postAllHtml');


	Route::get('package/track', 'TrackPackageController@index');
	Route::match(['get', 'post'], 'package/track/json', 'TrackPackageController@getActiveJson');
	Route::resource('todo', 'ToDoController');
	
	Route::get('profile/password', 'ProfileController@getPassword');
	Route::put('profile/password', 'ProfileController@putPassword');
	Route::resource('profile', 'ProfileController');
	
	/*------------------------------index Route------------------------------*/
	Route::get('/', 'DashboardController@getIndex');

	/*------------------------------Tools Route------------------------------*/
	Route::get('tools', 'DashboardToolsController@getIndex');
	Route::get('tools/country', 'DashboardToolsController@getCountry');
	Route::get('tools/calendar', 'DashboardToolsController@getCalendar');

	// get Request only
	Route::get('tools/airport/{request?}', 'DashboardToolsController@getAirport');
	Route::get('tools/destination/{request?}', 'DashboardToolsController@getDestination');

	// contact resource 
	Route::resource('tools/contacts', 'ContactsController');


	/*-----------------------------Enquiry Route-----------------------------*/
	Route::resource('enquiry/', 'EnquiryController');
	Route::post('enquiry/pending', 'EnquiryController@pending');

	/*----------------------------Follow Up Route----------------------------*/
	Route::get('follow-up/', 'FollowUpController@index');
	Route::post('follow-up/', 'FollowUpController@store');