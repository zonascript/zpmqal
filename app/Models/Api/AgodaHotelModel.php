<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;
class AgodaHotelModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'agoda_hotels';
	protected $appends = ['images'];

	public static function call()
	{
		return new AgodaHotelModel;
	}


	public function hotelsByCityId($cityId, $index = 0, $take = 50, $useCol = true)
	{
		$columns = [
				'id', 'hotel_id', 'hotel_name',
				DB::raw('CONCAT(addressline1, \', \', addressline2, \', \', zipcode,\', \', city, \', \', country) as address'),
				'star_rating', 'longitude', 'latitude', 'checkin', 'checkout', 
				'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'overview'
			];

		if (!$useCol) {
			$columns = '*';
		}

		$result = $this->select($columns)
										->skip($index*$take)->take($take)
										 ->where([['city_id', '=', $cityId]])
										 	->get();
		return ($result);
	}


	public function hotelsByCity($city, $useCol = true)
	{
		$columns = [
				'id', 'hotel_id', 'hotel_name',  
				 DB::raw('REPLACE(CONCAT(addressline1, \', \', addressline2, \', \', zipcode,\', \', city, \', \', country), \', ,\', \',\'); as address'),
				'star_rating', 'longitude', 'latitude', 'checkin', 'checkout', 
				'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'overview'
			];

		if (!$useCol) {
			$columns = '*';
		}

		return $this->select($columns)->where([['city', 'like', '%'.$city.'%']])->get();
	}

	/*
	| this function is to get hotel detail by hotels id
	*/
	public function hotelByAgodaId($agodaHotelId)
	{
		return $this->select()->where(['hotel_id' => $agodaHotelId])->first();
	}


	public function hotelDetail()
	{
		return $this->hasOne(
											'App\Models\Api\AgodaHotelDetailModel', 
											'hotel_id', 'hotel_id'
										);
	}

	public function hotelImages()
	{
		return $this->hasMany(
											'App\Models\Api\AgodaHotelImageModel', 
											'hotel_id', 'hotel_id'
										);
	}
	

	public function getImagesAttribute()
	{
		$result = $this->hotelImages;
		$images = [];

		if ($result->count()) {
			foreach ($result as $hotelImage) {
				$images[] = $hotelImage->LocationWithSquareSize2X;
			}
		}
		return $images;
	}

}
