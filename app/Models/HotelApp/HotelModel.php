<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class HotelModel extends Model
{
	protected $connection  = 'mysql4';
	protected $table = 'hotels';
	protected $appends = ['vendor_code'];
	protected $hidden = ['created_at', 'updated_at'];

	public function getVendorCodeAttribute()
	{
		$vendor = '';
		if ($this->vendor_type == 'App\Models\HotelApp\BookingHotelModel') {
			$vendor = 'b';
		}elseif ($this->vendor_type == 'App\Models\HotelApp\AgodaHotelModel') {
			$vendor = 'a';
		}
		return $vendor;
	}

	public function fatchHotelName($params)
	{
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;

		$sqlQuery = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, CONCAT(TRUNCATE(latitude,3), \'_\', TRUNCATE(longitude,3)) as lat_long');

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and name like \'%'.$name.'%\'';

		$result = $this->select('*', $sqlQuery)
										->whereRaw($whereRaw)
											->having('distance', '<', 20)
												->groupBy('lat_long')
													->orderBy('distance', 'asc')
														->offset(0)
	      											->limit(10)
																->get();
		
		$names = [];
		foreach ($result as $value) {
			$names[$value->name] = $value->name;
		}

		$names = array_values($names);
		return $names;
	}


	public function fatchHotels($params)
	{
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;
		$skip = isset($params->skip) ? $params->skip : 0;
		$take = isset($params->take) ? $params->take : 10;

		$sqlQuery = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, CONCAT(TRUNCATE(latitude,3), \'_\', TRUNCATE(longitude,3)) as lat_long');

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and name like \'%'.$name.'%\'';

		$result = $this->select('*', $sqlQuery)
										->whereRaw($whereRaw)
											->having('distance', '<', 20)
												->groupBy('lat_long')
													->orderBy('distance', 'asc')
														->offset($skip)
	      											->limit($take)
																->get();
		$hotels = [];
		foreach ($result as $resultValue) {
			$vendorHotel = $resultValue->vendor;

			$hotelId = $vendorHotel->id;
			if ($resultValue->vendor_code == 'a') {
				$hotelId = $vendorHotel->hotel_id;
			}

			$name = '';
			if (isset($vendorHotel->name)) {
				$name = $vendorHotel->name;
			}elseif (isset($vendorHotel->hotel_name)) {
				$name = $vendorHotel->hotel_name;
			}

			$name = proper($name);

			$starRating = '';
			if (isset($vendorHotel->star_rating)) {
				$starRating = $vendorHotel->star_rating;
			}elseif (isset($vendorHotel->class)) {
				$starRating = $vendorHotel->class;
			}


			$description = '';
			if (isset($vendorHotel->overview)) {
				$description = $vendorHotel->overview;
			}elseif (isset($vendorHotel->desc_en)) {
				$description = $vendorHotel->desc_en;
			}

			$image = '';
			if (isset($vendorHotel->photo1)) {
				$image = $vendorHotel->photo1;
			}elseif (isset($vendorHotel->photo_url)) {
				$image = $vendorHotel->photo_url;
			}

			$hotels[$name] = [
				'id' => $hotelId,
				'name' => $name,
				'longitude' => $vendorHotel->longitude,
				'latitude' => $vendorHotel->latitude,
				'vendor' => $resultValue->vendor_code,
				'address' => $vendorHotel->address,
				'star_rating' => $starRating,
				'description' => $description, 
				'image' => $image
			];
		}
		$hotels = array_values($hotels);
		return $hotels;
	}


	public function vendor()
	{
		return $this->morphTo();
	}


}
