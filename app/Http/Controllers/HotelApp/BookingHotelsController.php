<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelModel;

class BookingHotelsController extends Controller
{

	public static function call()
	{
		return new BookingHotelsController;
	}

	public function model()
	{
		return new BookingHotelModel;
	}

	public function hotelsByLatLong(Array $params)
	{
		/*$params = [
					'latitude' => -36.8484597, 
					'longitude' => 174.7633315, 
					'max_rating' => 5,
					'min_rating' => 0
		 	];*/

		return $this->model()->hotelsByLatLong($params);
	}



}
