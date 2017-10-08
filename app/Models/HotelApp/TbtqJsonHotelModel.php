<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TbtqJsonHotelModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_hotels';
	protected $casts = ['request' => 'object', 'response' => 'object'];
	protected $appends = [
			'trace_id', 'hotels', 'hotel_count', 'city_id', 
			'start_date', 'end_date', 'nights', 'is_date_passed'
		];


	public function setTokenAttribute()
	{
		if (!strlen($this->token)) {
			$this->attributes['token'] = new_token();
		}
	}


	public function getTokenIdAttribute()
	{
		return isset($this->request->TokenId)
				 ? $this->request->TokenId
				 : null;
	}

	public function getTraceIdAttribute()
	{
		return isset($this->response->HotelSearchResult->TraceId)
				 ? $this->response->HotelSearchResult->TraceId
				 : null;
	}


	public function getStartDateAttribute()
	{
		return Carbon::createFromFormat('d/m/Y', $this->request->CheckInDate);
	}

	public function getEndDateAttribute()
	{
		return $this->start_date->addDays($this->nights);
	}


	public function getNightsAttribute()
	{
		return $this->request->NoOfNights;
	}


	public function getCityIdAttribute()
	{
		return $this->request->CityId;
	}

	public function getHotelCountAttribute()
	{
		return isset($this->response->HotelSearchResult->HotelResults)
				 ? count($this->response->HotelSearchResult->HotelResults)
				 : 0;
	}


	public function getHotelsAttribute()
	{
		if (is_null($this->hotels)) {
			return $this->hotels();
		}
	}


	public function getIsDatePassedAttribute()
	{
		return $this->start_date->lt(Carbon::now());
	}


	public function destination()
	{
		return $this->hasOne(
				'App\Models\HotelApp\TbtqDestinationModel', 
				'destination_code', 'city_id'
			);
	}


	public function hotels()
	{
		$hotels = [];

		for ($i=0; $i < $this->hotel_count ; $i++) { 
			$hotels[] = $this->hotel($i);
		}

		return $hotels;
	}


	public function hotel($index)
	{
		$hotel = null;

		if (isset($this->response->HotelSearchResult->HotelResults[$index])) {

			$data = $this->response
							->HotelSearchResult
							 ->HotelResults[$index];

			$hotel = (object) [
					'vendor' => 'tbtq',
					'id' => $data->HotelCode,
					'name' => $data->HotelName,
					'latitude' => $data->Latitude,
					'image' => $data->HotelPicture,
					'longitude' => $data->Longitude,
					'address' => $data->HotelAddress,
					'star_rating' => $data->StarRating,
					'description' => $data->HotelDescription, 
					'price' => $data->Price->PublishedPriceRoundedOff,
				];
		}

		return $hotel;
	}



	public function hotelFromResponse($index)
	{
		return isset($this->response
												->HotelSearchResult
													->HotelResults[$index])
				 ? $this->response
										 ->HotelSearchResult
													->HotelResults[$index]
				 : null; 

	}



	public function makeHotelRoomRequest($index)
	{
		$hotel = $this->hotelFromResponse($index);
		return is_null($hotel) ? null : [
				"ResultIndex" => $hotel->ResultIndex,
				"HotelCode" => $hotel->HotelCode,
				"EndUserIp" => $_SERVER['REMOTE_ADDR'],
				"TokenId" => $this->TokenId,
				"TraceId" => $this->TraceId
			];
	}


	public function makeHotelInfoRequest($index)
	{
		return $this->makeHotelRoomRequest($index);
	}


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}

}
