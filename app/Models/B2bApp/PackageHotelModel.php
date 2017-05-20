<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\PackageHotelRoomModel;
use App\Http\Controllers\HotelApp\HotelsController;

class PackageHotelModel extends Model
{
	protected $table = 'package_hotels';
	protected $appends = ['detail'];

	public static function call(){
		return new PackageHotelModel;
	}

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
		$rooms = [];
		foreach ($this->packageRooms as $room) {
			if (isset($room->room->roomtype)) {
				$rooms[] = $room->room->roomtype;
			}
		}
		return $rooms;
	}

	public function hotelForView()
	{
		$params = ['code' => $this->hotel_code, 'vendor' => $this->vendor];
		return HotelsController::call()->hotelByCode($params);
	}


	public function hotelDetail()
	{
		$hotelDetail = $this->hotelForView();
		$hotelDetail = isset($hotelDetail[0]) ? $hotelDetail[0] : $this;
		$result = (object)[
				"id" => $this->id,
				"code" => $hotelDetail->id,
				"vendor" => $hotelDetail->vendor,
				"name" => $hotelDetail->name,
				"latitude" => $hotelDetail->latitude,
				"longitude" => $hotelDetail->longitude,
				"nights" => '',
				"location" => '',
				"endDate" => '',
				"startDate" => '',
				"address" => $hotelDetail->address,
				"city" => $hotelDetail->city,
				"country" => $hotelDetail->country,
				"roomType" => $this->hotelRooms(),
				"image" => $hotelDetail->image,
				"starRating" => $hotelDetail->star_rating,
				"starRatingHtml" => '',
				"description" => $hotelDetail->description,
				"shortDescription" => $hotelDetail->description,
				"htmlDescription" => $hotelDetail->description,
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
