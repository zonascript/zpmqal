<?php

Auth::routes();

Route::get('/', 'B2bApp\PagesController@getIndex');
Route::get('/pickme', 'B2bApp\PagesController@getPickMe');
Route::get('/test/showfile', 'TestController@showfile');
Route::get('/test/agoda', 'TestController@getAgodaHtml');
Route::get('/hellotravel/{id}', 'TestController@helloTravel');
Route::post('/hellotravel/{id}/save', 'TestController@saveHelloTravel');
Route::get('a/l/htdetail', 'Api\AgodaHotelsController@loopHotelDetails');
Route::get('insert/batch/hotel/b', 'HotelApp\ManageDataController@update');

/*==========================Temporary Route==========================*/
// Route::get('/fix/booking/data', 'TestController@fixData');

// This for package html
Route::get('/your/package/detail/{hashId}', 'B2bApp\PdfHtmlController@htmlByHashIdWithTrack');



Route::group(['middleware' => ['auth']], function(){

	/*---------------------------this is for logout--------------------------*/
	Route::get('/logout', function(){
		Auth::logout();
		return redirect('/');
	});

	/*-------------------- Home, Main And Public Pages Route ----------------*/
	Route::get('/home', 'HomeController@index');
	Route::get('/about', 'B2bApp\PagesController@getAbout');
	Route::get('/public', 'B2bApp\PagesController@getIndex');
	Route::get('/contact', 'B2bApp\PagesController@getContact');
	Route::get('/services', 'B2bApp\PagesController@getServices');

	// =========================Images Controller=========================
	Route::post('image/upload', 'B2bApp\ImagesController@upload');

	
	Route::post('/dashboard/todo/status', 'B2bApp\ToDoController@status');
	Route::post('/dashboard/todo/remove', 'B2bApp\ToDoController@remove');
	// Route::get('/dashboard/todo/all/json', 'B2bApp\ToDoController@all');
	Route::post('/dashboard/todo/all/json', 'B2bApp\ToDoController@postAllJson');
	Route::post('/dashboard/todo/all/html', 'B2bApp\ToDoController@postAllHtml');
	Route::get('/dashboard/package/track', 'B2bApp\TrackPackageController@index');
	Route::get('/dashboard/package/track/json', 'B2bApp\TrackPackageController@getActiveJson');
	Route::post('/dashboard/package/track/json', 'B2bApp\TrackPackageController@getActiveJson');
	Route::resource('/dashboard/todo', 'B2bApp\ToDoController');
	
	Route::get('/dashboard/profile/password', 'B2bApp\ProfileController@getPassword');
	Route::put('/dashboard/profile/password', 'B2bApp\ProfileController@putPassword');

	Route::resource('/new/destination', 'B2bApp\DestinationController');
	
	Route::resource('/dashboard/profile', 'B2bApp\ProfileController');

	
	/*------------------------------redirect Route------------------------------*/
	Route::get('redirect/{hashId}', 'Common\RedirectController@redirectNow');

	/*
	|===========================================================================
	| Start Dashboard Routes
	|===========================================================================
	*/

		/*------------------------------index Route------------------------------*/
			Route::get('/dashboard', 'B2bApp\DashboardController@getIndex');
		


		/*------------------------------Tools Route------------------------------*/
			Route::get('/dashboard/tools', 'B2bApp\DashboardToolsController@getIndex');
			Route::get('/dashboard/tools/country', 'B2bApp\DashboardToolsController@getCountry');
			Route::get('/dashboard/tools/calendar', 'B2bApp\DashboardToolsController@getCalendar');

			// get Request only
			Route::get('/dashboard/tools/airport/{request?}', 'B2bApp\DashboardToolsController@getAirport');
			Route::get('/dashboard/tools/destination/{request?}', 'B2bApp\DashboardToolsController@getDestination');
		
			// contact resource 
			Route::resource('/dashboard/tools/contacts', 'B2bApp\ContactsController');


		/*-----------------------------Enquiry Route-----------------------------*/
			Route::resource('/dashboard/enquiry/', 'B2bApp\EnquiryController');
			Route::post('/dashboard/enquiry/pending', 'B2bApp\EnquiryController@pending');

		/*----------------------------Follow Up Route----------------------------*/
			Route::get('/dashboard/follow-up/', 'B2bApp\FollowUpController@index');
			Route::post('/dashboard/follow-up/', 'B2bApp\FollowUpController@store');


		
		/*
		|===========================================================================
		| Start Package Builder Routes
		|===========================================================================
		*/

			/*---------------------------Package all Route---------------------------*/
				
				Route::get('dashboard/package/open/{id}', 'B2bApp\PackageController@open');


				// Here all Package will show like list of package 
				Route::get('/dashboard/package/all/{id}', 'B2bApp\PackageController@index');
				
				// here only specific package will show
				Route::get('/dashboard/package/all/{id}/{packageDbId}', 'B2bApp\PackageController@show');
				
				// this will save package cost
				Route::post('/dashboard/package/savecost/{id}/{packageDbId}', 'B2bApp\PackageController@saveCost');
				
				// it will generate html of a specific package
				Route::get('/dashboard/package/html/{packageDbId}', 'B2bApp\PackageController@getCreatePdfHtml');

				// it will generate pdf of a specific package
				Route::get('/dashboard/package/pdf/{hashId}', 'B2bApp\PackageController@getCreatePdf');

			/*-------------------New enquiry creation will oprate here-------------------*/
				// this route is gui to get information
				Route::get('/dashboard/package/create/{id}', 'B2bApp\PackageBuilderController@create');
				// this route will store the information into DB
				Route::post('/dashboard/package/create/{id}', 'B2bApp\PackageBuilderController@store');


			/*-------------------------New enquiry creation will-------------------------*/
				// this route is gui to get information
				Route::get('/dashboard/package/route/{id}', 'B2bApp\RouteController@create');
				// this route will store the information into DB
				Route::post('/dashboard/package/route/{id}', 'B2bApp\RouteController@store');
				// this for finding next event
				Route::get('/dashboard/package/event/{routeDbId}', 'B2bApp\PackageController@getEvent');
				Route::get('/dashboard/package/builder/event/{packageDbId}/{current}', 'B2bApp\PackageController@findNextEvent');


			/*--------------------------Package Itinerary Maker--------------------------*/
			/*
			| here all branch will show mean what you want in your package 
			| like Hotels, Flights, Cabs, Activities and more.
			| this will carry (htt../dashboard/package/create/{id}) Routes
			| date and room guests detail and that will never change if you want to change 
			| for that you have to create new package using [build new package] button 
			*/
				Route::get('/dashboard/package/itinerary/all/{id}/{packageDbId}', 'B2bApp\PackageBuilderController@show');

				/*------------------------here individual sector targeted------------------------*/
				/*
				| this route is for arranging order destination and loaction for the specific sector 
				| for example hotel Route::get('...itinerary/hotels/{id}' is for Hotels
				| after getting the information for saving this will point save route 
				| using post request then in the return back it will give a redirect like in json 
				| like:- {"nestUrl":"http...builder/hotel/{id}/{packageDbId}/{packageHotelId}"}
				| so using ajax and jquery this will redirect
				*/

				// Get Request 
				Route::get('/dashboard/package/itinerary/cabs/{id}/{packageDbId}', 'B2bApp\ItineraryController@getCabs');
				Route::get('/dashboard/package/itinerary/hotels/{id}/{packageDbId}', 'B2bApp\ItineraryController@getHotels');
				Route::get('/dashboard/package/itinerary/flights/{id}/{packageDbId}', 'B2bApp\ItineraryController@getFlights');
				Route::get('/dashboard/package/itinerary/activities/{id}/{packageDbId}', 'B2bApp\ItineraryController@getActivities');
				
				// Post Request
				Route::post('/dashboard/package/itinerary/cabs/{id}/{packageDbId}', 'B2bApp\ItineraryController@postCabs');
				Route::post('/dashboard/package/itinerary/hotels/{id}/{packageDbId}', 'B2bApp\ItineraryController@postHotels');
				Route::post('/dashboard/package/itinerary/flights/{id}/{packageDbId}', 'B2bApp\ItineraryController@postFlights');
				Route::post('/dashboard/package/itinerary/activities/{id}/{packageDbId}', 'B2bApp\ItineraryController@postActivities');
				Route::post('/dashboard/package/itinerary/activities/copytohotel/{id}/{packageDbId}', 'B2bApp\ItineraryController@postCopyHotelIti');




			//====================================Flights====================================

				Route::get('/dashboard/package/builder/flights/{packageDbId?}', 'B2bApp\FlightsController@getFlightsByPackageId');
				Route::get('/dashboard/package/builder/flight/result/{flightDbId?}', 'B2bApp\FlightsController@getFlightsResult');
				Route::get('/dashboard/package/builder/flight/{flightDbId?}', 'B2bApp\FlightsController@getFlights');
			
				Route::post('/dashboard/package/builder/flight/book/{flightDbId?}', 'B2bApp\FlightsController@postBookFlightsResult');
				Route::post('/dashboard/package/builder/flight/{flightDbId}', 'B2bApp\FlightsController@postFlights');
		
				Route::delete('/dashboard/package/builder/flight/{flightDbId?}', 'B2bApp\FlightsController@deleteFlightResult');




			/* =================================Package Hotel=================================
			| id = Clients table index or id
			| packageDbId = packages table index or id
			|	packageHotelId = package_hotels table or id
			*/
				Route::get('/dashboard/package/builder/hotels/{packageDbId?}', 'B2bApp\HotelsController@getHotelsByPackageId');

				Route::get('/dashboard/package/builder/hotel/{packageHotelId}', 'B2bApp\HotelsController@getHotelView');
				Route::post('/dashboard/package/builder/hotel/search/{packageHotelId}', 'B2bApp\HotelsController@storeSearch');
				
				Route::post('/dashboard/package/builder/hotel/remove/{packageHotelId}', 'B2bApp\HotelsController@postRemoveHotelRoom');

				// Fatch Hotel Room 
				Route::post('/dashboard/package/builder/hotel/room/{packageHotelId}', 'B2bApp\HotelsController@postHotelRoom');
				// Book Hotel Room
				Route::post('/dashboard/package/builder/hotel/room/book/{packageHotelId}', 'B2bApp\HotelsController@postBookHotelRoom');


			/* ====================================Cruise====================================
			| id = Clients table index or id
			| packageDbId = packages table index or id
			|	packageCruiseId = package_cruises table or id
			*/
				Route::get('/dashboard/package/builder/cruises/{packageDbId?}', 'B2bApp\CruisesController@getCruisesByPackageId');

				Route::get('/dashboard/package/builder/cruise/{id}/{packageDbId}/{packageCrusiesId}', 'B2bApp\CruisesController@getCruises');
				Route::post('/dashboard/package/builder/cruise/search/{id}/{packageDbId}/{packageCrusiesId}', 'B2bApp\CruisesController@storeSearch');
				// Fatch Cruise Room 
				Route::post('/dashboard/package/builder/cruise/cabin/{id}/{packageDbId}/{packageCrusiesId}', 'B2bApp\CruisesController@getCruiseCabin');

				// Book Cruise Room
				Route::post('/dashboard/package/builder/cruise/cabin/book/{id}/{packageDbId}/{packageCrusiesId}', 'B2bApp\CruisesController@postBookCrusieCabin');


			//===================================Activities===================================
				Route::get('/dashboard/package/builder/activities/{packageDbId}', 'B2bApp\ActivitiesController@getActivitiesByPackageId');
				Route::post('/dashboard/package/builder/activities/{packageDbId}', 'B2bApp\ActivitiesController@postActivities');
				
				Route::post('/dashboard/package/builder/activities/save/{id}', 'B2bApp\ActivitiesController@saveActivities');




			// =====================================Cars======================================
				Route::get('/dashboard/package/builder/car/{packageDbId}', 'B2bApp\CarsController@create');

				Route::post('/dashboard/package/builder/car/{packageDbId}', 'B2bApp\CarsController@postCar');

				Route::post('/dashboard/package/builder/car/{packageDbId}/choose', 'B2bApp\CarsController@chooseCar');

				Route::post('/dashboard/package/builder/car/{packageDbId}/menu', 'B2bApp\CarsController@postMenu');

				Route::delete('/dashboard/package/builder/car/{packageDbId}', 'B2bApp\CarsController@destroy');


			//======================================Cabs======================================
				Route::get('/dashboard/package/builder/cab/auth', 'Api\UberApiController@auth');
				Route::get('/dashboard/package/builder/cab/auth/token', 'Api\UberApiController@getToken');
				Route::get('/dashboard/package/builder/cab/current', 'Api\UberApiController@testCurrentRequest');

				Route::get('/dashboard/package/builder/cab/{id}/{packageDbId}', 'B2bApp\CabsController@index');
				
				Route::post('/dashboard/package/builder/cab/{id}/{packageDbId}', 'B2bApp\CabsController@postProduct');
				Route::post('/dashboard/package/builder/cab/book/{id}/{packageDbId}', 'B2bApp\CabsController@postBook');
				Route::post('/dashboard/package/builder/cab/pickup/{id}/{packageDbId}', 'B2bApp\CabsController@postPickUp');


		/*
		|===========================================================================
		| End Package Builder Routes
		|===========================================================================
		*/

	/*
	|===========================================================================
	| End Dashboard Routes
	|===========================================================================
	*/
	
	Route::get('/dashboard/uber/request', 'Api\UberApiController@testRequestRide');
	
	Route::get('/dashboard/uber', 'B2bApp\UberController@getUber');
	Route::any('/dashboard/uber/auth', 'B2bApp\UberController@auth');
	Route::get('/dashboard/uber/product', 'B2bApp\UberController@getProductsTest');
	Route::get('/dashboard/buber', 'B2bApp\UberController@basvandorstUber');
	
	Route::get('/dashboard/api/cruise', 'Api\CruiseController@cruise');
	Route::get('/dashboard/api/cruise/cabin', 'Api\CruiseController@cruiseCabin');
	
	/*
	|===========================================================================
	| Api Request
	|===========================================================================
	*/

	// =================================Flights=================================
	Route::get('/qpx/flights/result/{id}', 'B2bApp\FlightsController@postQpxFlightResult');
	Route::post('/qpx/flights/result/{id}', 'B2bApp\FlightsController@postQpxFlightResult');
	
	Route::get('/ss/flights/result/{id}', 'B2bApp\FlightsController@postSkyscannerFlightResult');
	Route::post('/ss/flights/result/{id}', 'B2bApp\FlightsController@postSkyscannerFlightResult');

	// =================================hotels==================================
	// Route::get('/ss/hotels/result/{id}', 'B2bApp\HotelsController@postSkyscannerHotelResult');
	
	Route::post('/t/hotels/result/{id}', 'B2bApp\HotelsController@postTbtqHotelResult');
	Route::post('/ss/hotels/result/{id}', 'B2bApp\HotelsController@postSkyscannerHotelResult');
	
	Route::get('/a/hotels/result/{id}/{index?}', 'B2bApp\HotelsController@postFgfAgodaHotelResult');
	Route::post('/a/hotels/result/{id}/{index?}', 'B2bApp\HotelsController@postFgfAgodaHotelResult');
	Route::get('/a/hotel/rooms/{id}', 'B2bApp\HotelsController@postFgfAgodaHotelRoomResult');
	Route::post('/a/hotel/rooms/{id}', 'B2bApp\HotelsController@postFgfAgodaHotelRoomResult');

	Route::get('/a/hotel/detail/{id}', 'B2bApp\HotelsController@postFgfAgodaHotelDetail');
	Route::post('/a/hotel/detail/{id}', 'B2bApp\HotelsController@postFgfAgodaHotelDetail');



	// ===================================cruise===================================
	Route::get('/f/cruises/result/{id}', 'B2bApp\CruisesController@postFgfCruiseResult');
	Route::post('/f/cruises/result/{id}', 'B2bApp\CruisesController@postFgfCruiseResult');
	Route::get('/f/cruises/cabin/{id}', 'B2bApp\CruisesController@postFgfCruiseCabin');
	Route::post('/f/cruises/cabin/{id}', 'B2bApp\CruisesController@postFgfCruiseCabin');


	// =================================Activities=================================
	Route::get('/uni/activities/result/{id}', 'B2bApp\ActivitiesController@postUnionActivitiesResult');
	Route::post('/uni/activities/result/{id}', 'B2bApp\ActivitiesController@postUnionActivitiesResult');
	// Route::get('/vtr/activities/result/{id}', 'B2bApp\ActivitiesController@postViatorActivitiesResult');
	// Route::post('/fgf/activities/result/{id}', 'B2bApp\ActivitiesController@postFgfActivitiesResult');
	// Route::post('/vtr/activities/result/{id}', 'B2bApp\ActivitiesController@postViatorActivitiesResult');





	// Test Request

	Route::get('/skyscanner/flights', 'Api\SkyscannerFlightsApiController@postFlight');
	Route::get('/skyscanner/cars', 'B2bApp\CarsController@getCars');

	Route::get('/skyscanner/test/cars', 'B2bApp\SkyscannerCarsController@test');



	Route::get('dashboard/data/viator/product', 'Api\ViatorController@fatchProductByDestination');
	Route::get('dashboard/data/viator/product/detail', 'Api\ViatorController@fatchProductDetail');

	Route::get('/dashboard/test/auth', 'Api\EanApiController@auth1');
	// Route::get('/dashboard/test/destinationlist', 'Api\TbtqController@CountyList');
	// Route::get('/dashboard/test/destination-list', 'Api\TbtqController@destinationList');
	// Route::get('/dashboard/test/destination/insert', 'Api\DestinationController@insert');
	Route::get('/dashboard/test/activities/', 'Api\ActivityController@all');
	Route::get('/dashboard/test/image/', 'Api\ImageController@all');
	// Route::get('/dashboard/test/copyimage/', 'Api\ImageController@copy');

	Route::get('/scrape/data/activities', 'Api\ScrapeController@expedia');
	// Route::get('/scrape/data/jainwoodcrafts', 'Api\ScrapeController@jainWoodCrafts');


});