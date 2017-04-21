<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\HotelApp\HotelModel;

// controller
use App\Http\Controllers\HotelApp\AgodaHotelsController;
use App\Http\Controllers\HotelApp\BookingHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelsRoomsController;
use App\Http\Controllers\HotelApp\BookingHotelRoomsController;


class HotelsController extends Controller
{
	public static function call()
	{
		return new HotelsController;
	}

	public function model()
	{
		return new HotelModel;
	}

	public function hotels($params = [])
	{
 		$hotels = BookingHotelsController::call()->hotelsByLatLong($params);

 		if (!$hotels->count()) {
 			$hotels = AgodaHotelsController::call()->hotelsByLatLong($params);
 		}

 		return $hotels;
	}


	public function hotelRooms($params = [])
	{
		$params = (object) $params;
		$result = [];

		if ($params->vendor == 'b') {
			$result = BookingHotelRoomsController::call()->rooms($params->id);
		}
		elseif ($params->vendor == 'a') {
			$result = AgodaHotelRoomsController::call()->rooms($params->id);
		}

		return $result;
	}

	public function searchHotels($params=[])
	{
		$params = (object) $params;
		$result = $this->model()->fatchHotels($params);
		return $result; 
	}


	public function searchHotelsByName($params=[])
	{
		$params = (object) $params;
		return $this->model()->fatchHotelName($params);
	}




}