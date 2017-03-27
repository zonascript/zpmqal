<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Model;
use DB;


class DestinationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'destinations';
	protected $appends = ['location', 'echo_location'];

	protected $hidden = [
		'created_at', 'updated_at',
	];
	

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
