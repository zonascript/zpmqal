<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqJsonHotelInfoModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_hotel_infos';
	protected $appends = ['status', 'details'];
	protected $casts = ['request' => 'object', 'response' => 'object'];
	protected $hidden = ['details', 'attractions'];

	public function getStatusAttribute()
	{
		return isset($this->response->HotelInfoResult->ResponseStatus)
				 ? $this->response->HotelInfoResult->ResponseStatus
				 : 0;
	}


	public function getDetailsAttribute()
	{
		return $this->status == 1
				 ? $this->response->HotelInfoResult->HotelDetails
				 : null;
	}


	public function getAttractionsAttribute()
	{
		$result = [];
		if (isset($this->details->Attractions)) {
			foreach ($this->details->Attractions as $attraction) {
				$result[] = $attraction->Value;
			}
		}
		return $result;
	}



	public function details()
	{
		return is_null($this->details) ? null : (object) [
					"name" => $this->details->HotelName,
					"code" => $this->details->HotelCode,
					"images" => $this->details->Images,
					"url" => $this->details->HotelURL,
					"address" => $this->details->Address,
					"latitude" => $this->details->Latitude,
					"longitude" => $this->details->Longitude,
					"star_rating" => $this->details->StarRating,
					"description" => $this->details->Description,
					"attractions" => $this->attractions,
					"facilities" => $this->details->HotelFacilities,
				];
	}

}
