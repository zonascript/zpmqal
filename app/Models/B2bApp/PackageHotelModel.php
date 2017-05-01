<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\PackageHotelRoomModel;
use App\Http\Controllers\HotelApp\HotelsController;
use DB;

class PackageHotelModel extends Model
{
	protected $table = 'package_hotels';
	protected $appends = ['detail'];
	protected $casts = [
			'request' => 'object',
			'result' => 'object'
		];


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}


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


	public function hotelForView()
	{
		$params = ['code' => $this->hotel_code, 'vendor' => $this->vendor];
		return HotelsController::call()->hotelByCode($params);
		// id
		// address
		// city
		// country
		// image
		// latitude
		// longitude
		// name
		// vendor
		// description
		// star_rating
	}

	public function agoda()
	{
		
	}

	/*
	| this function to find hotal's data from db behalf of logged in user or agent
	*/
	public function usersFind($id)
	{
		return $this->select()
									->where(['id' => $id])
										->first();
	}


	/*
	| this function is for getting route of that route
	*/
	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');		
	}


	/*
	| this function is for getting package data 
	| from package table behalf of package_id
	*/
	public function tbtqHotel()
	{
		return $this->belongsTo('App\Models\Api\TbtqHotelModel', 'tbtq_hotel_id');		
	}



	public function skyscannerHotel()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerHotelModel', 'skysacanner_hotel_id');
	}


	public function bookingHotelRoom()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\BookingHotelRoomModel', 
											'booking_hotel_room_id', 'id'
										);
	}

	public function agodaHotelRoom()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\AgodaHotelRoomModel', 
											'agoda_hotel_room_id'
										);
	}

	public function activities()
	{
		return $this->hasOne('App\Models\B2bApp\PackageActivityModel', 'package_hotel_id');		
	}


	public function getDetail()
	{

		$result = (object)[
				"id" => '',
				"code" => '',
				"vendor" => '',
				"name" => '',
				"latitude" => '',
				"longitude" => '',
				"nights" => $this->route->nights,
				"location" => $this->route->destination_detail->location,
				"endDate" => $this->route->end_datetime->format('d-M-Y'),
				"startDate" => $this->route->start_datetime->format('d-M-Y'),
				"address" => '',
				"city" => '',
				"country" => 'country',
				"roomType" => '',
				"image" => '',
				"address" => '',
				"starRating" => '',
				"starRatingHtml" => '',					
				"description" => '',
				"shortDescription" => '',
				"htmlDescription" => '',
			];
		if ($this->selected_hotel_vendor == 'a') {
			$agodaHotel = $this->agodaHotelRoom->agodaHotel;
			$result->vendor = 'agoda';
			$result->code = $agodaHotel->id;
			$result->name = proper($agodaHotel->hotel_name);
			$result->image = $agodaHotel->photo1;
			$result->address = $agodaHotel->address;
			$result->roomType = $this->agodaHotelRoom->roomtype;
			$result->description = $agodaHotel->overview;
			$result->starRating = $agodaHotel->star_rating;
			$result->htmlDescription = $agodaHotel->hotelDetail->details;
		}
		elseif ($this->selected_hotel_vendor == 'b') {
			$bookingHotel = $this->bookingHotelRoom->bookingHotel;
			$result->vendor = 'booking';
			$result->code = $bookingHotel->id;
			$result->name = proper($bookingHotel->name);
			$result->image = $bookingHotel->photo_url;
			$result->address = $bookingHotel->address;
			$result->roomType = $this->bookingHotelRoom->roomtype;
			$result->description = $bookingHotel->desc_en;
			$result->starRating = $bookingHotel->class;
			$result->htmlDescription = $bookingHotel->desc_en;
		}
		elseif ($this->selected_hotel_vendor == 'ss') {
			$result->name = proper($this->skyscannerHotel->name);
			$result->image = $this->skyscannerHotel->hotelDetail->images[0];
			$result->description = $this->skyscannerHotel
														->hotelDetail->result->hotels[0]->description;
			$result->htmlDescription = $result->description;
			$result->starRating = $this->skyscannerHotel->star_rating;
		}
		elseif ($this->selected_hotel_vendor == 'tbtq') {
			$result->name = proper($this->tbtqHotel->hotel->HotelName);
			$result->image = $this->tbtqHotel->hotel->HotelPicture;
			$result->description = $this->tbtqHotel->hotel->HotelDescription;
			$result->htmlDescription = $result->description;
			$result->starRating = $this->tbtqHotel->hotel->StarRating;
		}

		$result->starRatingHtml = getStarImage($result->starRating, 15, 15);
		$result->shortDescription = sub_string($result->description, 120);

		return $result;
	}


	public function images()
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
