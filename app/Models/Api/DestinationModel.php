<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Api\GoogleMapController;
use DB;

class DestinationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'destinations';
	protected $casts = ['geocode' => 'object'];
	protected $appends = ['location', 'echo_location'];
	protected $hidden = ['created_at', 'updated_at'];

	public function getLatitudeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
			$value = isset($value->results[0]->geometry->location->lat)
						 ? $value->results[0]->geometry->location->lat 
						 : null;
		}

		return $value;
	}
	

	public function getLongitudeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
			$value = isset($value->results[0]->geometry->location->lng)
						 ? $value->results[0]->geometry->location->lng 
						 : null;
		}

		return $value;
	}

	public function getGeocodeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
		}
		else{
			$value = json_decode($value);
		}

		return $value;
	}


	public function getLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['destination']) 
						 ? $this->attributes['destination']
						 : '';

		return $destination.", ".$country;
	}


	public function getEchoLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['destination']) 
						 ? $this->attributes['destination']
						 : '';

		return echoLocation($destination, $country);
	}

	public function pullGeocode()
	{
		$value = GoogleMapController::call()->geoCode($this->location);

		if (isset($value->results[0]->geometry->location->lat) && isset($value->results[0]->geometry->location->lng)) {
			$this->latitude = $value->results[0]->geometry->location->lat;
			$this->longitude = $value->results[0]->geometry->location->lng;
			$this->geocode = $value;
			$this->save();
		}

		return $value;
	}

	public static function call(){
		return new DestinationModel;
	}

	public function search($search){

		$result = $this->select()
							->whereRaw("CONCAT(`destination`, ', ', `country`) = '$search'")
								->first();

		return  $result;
	}


	public function getLocation($search, $tags = null){
		$isTag = $tags == null ? '' : "AND tags LIKE '%$tags%'";
		$where = "CONCAT(`destination`, ', ', `country`) LIKE '%$search%' $isTag";
		$result = $this->select()->whereRaw($where)->get();
		return  $result;
	}


	public function getLocationRight($search, $tags = null){
		$isTag = $tags == null ? '' : "AND tags LIKE '%$tags%'";
		$where = "CONCAT(`destination`, ', ', `country`) LIKE '$search%' $isTag";
		$result = $this->select()->whereRaw($where)->get();
		return  $result;
	}



	public function self_find($id){
		$result = $this->select()
						->where(['id' => $id])
						->first();

		return $result;
	}

	/*
	| this function is made for finding data by fgf_destinationCode
	*/
	public function findByDcode($fgf_destinationcode){
		$result = $this->select(["id", "country", "fgf_countrycode", "tbtq_countrycode", 
								"destination", "fgf_destinationcode","tbtq_destinationcode", "api"])
						->where(['fgf_destinationcode' => $fgf_destinationcode])
						->first();
		return $result;
	} 

}
