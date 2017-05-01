<?php 
	/* ============================Cruise============================
	| id = Clients table index or id
	| packageDbId = packages table index or id
	|	packageCruiseId = package_cruises table or id
	*/
	Route::get('dashboard/package/builder/cruises/{packageDbId?}', 'CruisesController@getCruisesByPackageId');
	// Book Cruise Room
	Route::post('dashboard/package/builder/cruise/cabin/book/{packageCruiseId}', 'CruisesController@postBookCrusieCabin');
	
	
	// Route::get('o/cruises/result', 'Api\CruiseController@cruises');
	// Route::get('check/cruises/result', 'CruisesController@itinerary');
	Route::get('fo/cruises/result/{id}', 'CruisesController@postFgfOnlyCruise');
	Route::post('fo/cruises/result/{id}', 'CruisesController@postFgfOnlyCruise');
	Route::get('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::get('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::post('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::get('f/cruises/cabin/{id}', 'CruisesController@postFgfCruiseCabin');
	Route::post('f/cruises/cabin/{id}', 'CruisesController@postFgfCruiseCabin');

	Route::get('dashboard/api/cruise', 'Api\CruiseController@cruise');
	Route::get('dashboard/api/cruise/cabin', 'Api\CruiseController@cruiseCabin');
	