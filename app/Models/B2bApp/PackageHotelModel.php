<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\PackageHotelRoomModel;
use App\Http\Controllers\HotelApp\HotelsController;
use App\Traits\CallTrait;

class PackageHotelModel extends Model
{
	use CallTrait;

	protected $table = 'package_hotels';
	protected $appends = ['detail'];


	public function roomModel()
	{
		return new PackageHotelRoomModel;
	}


	public function packageRooms()
	{
		return $this->hasMany(
							'App\Models\B2bApp\PackageHotelRoomModel', 
							'package_hotel_id'
						);
	}


	public function hotelRooms()
	{
		return $this->packageRooms->pluck('room.roomtype')->toArray(); //added new line
		
		$rooms = [];
		foreach ($this->packageRooms as $room) {
			if (isset($room->room->roomtype)) {
				$rooms[] = $room->room->roomtype;
			}
		}
		return $rooms;
	}


	public function selectedHotel()
	{
		if ($this->vendor == 'b') {
			return $this->belongsTo(
							'App\Models\HotelApp\BookingHotelModel', 
							'hotel_code'
						);
		}
		elseif ($this->vendor == 'a') {
			return $this->belongsTo(
									'App\Models\HotelApp\AgodaHotelModel', 
									'hotel_code', 'hotel_id'
								);
		}
		else{
			return null;
		}

	}



	public function hotelForView()
	{
		$params = ['code' => $this->hotel_code, 'vendor' => $this->vendor];
		return HotelsController::call()->hotelByCode($params);
	}


	public function hotelDetail()
	{
		$hotelDetail = collect($this->selectedHotel->built_data);
		$result = (object)[
				"id" => $this->id,
				"code" => $hotelDetail->get('code'),
				"vendor" => $hotelDetail->get('vendor'),
				"name" => $hotelDetail->get('name'),
				"latitude" => $hotelDetail->get('latitude'),
				"longitude" => $hotelDetail->get('longitude'),
				"nights" => '',
				"location" => '',
				"endDate" => '',
				"startDate" => '',
				"address" => $hotelDetail->get('address'),
				"city" => $hotelDetail->get('city'),
				"country" => $hotelDetail->get('country'),
				"roomType" => $this->hotelRooms(),
				"image" => $hotelDetail->get('image'),
				"starRating" => $hotelDetail->get('star_rating'),
				"starRatingHtml" => '',
				"description" => $hotelDetail->get('description'),
				"shortDescription" => $hotelDetail->get('description'),
				"htmlDescription" => $hotelDetail->get('description'),
			];

		$result->starRatingHtml = getStarImage($result->starRating, 15, 15);
		$result->shortDescription = sub_string($result->description, 120);

		return $result;
	}


	public function images()
	{
		$hotelDetail = $this->hotelForView();
		$images = [];
		if (isset($hotelDetail[0])) {
			$images = $hotelDetail[0]->images();
		}
		return $images;
	}

	public function imagesOld()
	{
		$images = [];
		$tempImg = [];

		if ($this->selected_hotel_vendor == 'tbtq') {
			$tempImg = $this->tbtqHotel
										->tbtqDetail->result
											->HotelInfoResult
												->HotelDetails->Images;

			$images = array_merge($images, $tempImg);
		}
		elseif ($this->selected_hotel_vendor == 'ss') {
			$tempImg = $this->skyscannerHotel->hotelDetail->images;
			$images = array_merge($images, $tempImg);
		}
		elseif ($this->selected_hotel_vendor == 'a') {
			$images = array_merge($images, $this->agodaHotelRoom->agodaHotel->images());
		}
		elseif ($this->selected_hotel_vendor == 'b') {
			$images = array_merge($images, $this->bookingHotelRoom->bookingHotel->images());
		}
		return $images;
	}

}
