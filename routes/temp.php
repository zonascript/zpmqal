<?php 

Route::get('/test/run', 'TestController@test');
Route::get('show-duplicate', 'ShowDuplicate@show');
Route::get('show-delete-duplicate', 'ShowDuplicate@delete');

// Route::get('pickme', 'B2bApp\PagesController@getPickMe');

Route::get('test/code', 'TestController@testCode');
Route::get('test/code', 'TestController@testCode');
Route::get('test/decode', 'TestController@decode');
Route::get('test/showfile', 'TestController@showfile');

// vendor test
Route::get('test/booking/html', 'TestController@testBookingHtml');
// Route::get('test/agoda', 'TestController@getAgodaHtml');
// Route::get('test/cleartrip', 'TestController@testClearTrip');
// Route::get('hellotravel/{id}', 'TestController@helloTravel');
// Route::post('hellotravel/{id}/save', 'TestController@saveHelloTravel');

Route::get('a/l/htdetail', 'HotelApp\AgodaHotelsController@loopHotelDetails');
// Route::get('insert/batch/hotel/b', 'HotelApp\ManageDataController@update');

/*======================Temporary Route======================*/
// Route::get('fix/booking/data', 'TestController@fixData');