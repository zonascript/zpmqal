<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
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


	public function agodaHotel()
	{
		return $this->belongsTo(
											'App\Models\Api\AgodaHotelModel', 
											'agoda_hotel_id', 'hotel_id'
										);
	}

	public function agodaHotelRoom()
	{
		return $this->belongsTo(
											'App\Models\Api\AgodaHotelRoomModel', 
											'agoda_hotel_room_id'
										);
	}

	public function activities()
	{
		return $this->hasOne('App\Models\B2bApp\PackageActivityModel', 'package_hotel_id');		
	}


	public function getDetailAttribute()
	{
		$result = (object)[
				"code" => '',
				"vendor" => '',
				"name" => '',
				"nights" => $this->route->nights,
				"location" => $this->route->destination_detail->location,
				"endDate" => $this->route->end_datetime->format('d-M-Y'),
				"startDate" => $this->route->start_datetime->format('d-M-Y'),
				"address" => '',
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
			$result->vendor = 'agoda';
			$result->code = $this->agodaHotel->id;
			$result->name = proper($this->agodaHotel->hotel_name);
			$result->image = $this->agodaHotel->photo1;
			$result->address = $this->agodaHotel->address;
			$result->roomType = $this->agodaHotelRoom->roomtype;
			$result->description = $this->agodaHotel->overview;
			$result->starRating = $this->agodaHotel->star_rating;
			$result->htmlDescription = $this->agodaHotel->hotelDetail->details;
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
			$images = array_merge($images, $this->agodaHotel->images);
		}

		return $images;
	}

}
