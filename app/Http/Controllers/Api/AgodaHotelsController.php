<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\AgodaHotelRoomsController;
use App\Http\Controllers\Api\AgodaHotelImagesController;
use App\Http\Controllers\Api\AgodaHotelDetailsController;

// ==============================Models==============================
use App\Models\Api\AgodaHotelModel;


class AgodaHotelsController extends Controller
{
	public static function call()
	{
		return new AgodaHotelsController;
	}

	public function model()
	{
		return new AgodaHotelModel;
	}

	public function hotels($cityId, $index)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotels = AgodaHotelModel::call()->hotelsByCityId($cityId, $index);
		}
		
		return $hotels;
	}


	public function searchHotelByName($cityId, $name)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotels = AgodaHotelModel::call()->searchHotelByName($cityId, $name);
		}
		
		return $hotels;
	}


	public function searchHotelsByName($cityId, $name)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotelsData = AgodaHotelModel::call()->searchHotelsByName($cityId, $name);
			foreach ($hotelsData as $hotelData) {
				$hotels[] = $hotelData->hotel_name;
			}
		}
		
		return $hotels;
	}


	public function storeHotelDetail()
	{
		$agodaHotel = AgodaHotelModel::select()
									->where(['is_stored_room' => 0])
										->first();
										
		if (!is_null($agodaHotel)) {
			$agodaHotelId = $agodaHotel->hotel_id;
			$url = 'https://www.agoda.com'.$agodaHotel->url;
			$rooms = AgodaHotelRoomsController::call()->extractRoomDetails($url,true);
			AgodaHotelRoomsController::call()->storeRooms($rooms->rooms, $agodaHotelId);
			AgodaHotelImagesController::call()->bulkInsert($rooms->images, $agodaHotelId);
			AgodaHotelDetailsController::call()->hotelDetail($agodaHotelId);
			$agodaHotel->is_stored_room = 1;
			$agodaHotel->save();
		}

		return $agodaHotel;

	}

	public function loopHotelDetails()
	{
		ini_set('max_execution_time', 3600);

		if (!isLocalhost()) {
			for ($i=1; $i > 0; $i++) { 
				$result = $this->storeHotelDetail();
				if (is_null($result)) {
					break;
				}
			}
		}
	}
	
}
