<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;

class CruiseOnlyDateModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'cruise_only_dates';


	public static function call()
	{
		return new CruiseOnlyDateModel;
	}

	/*
	| params = ['date' => Y-m-d, 'cityId' => '', 'nights' => '5'];
	*/
	public function cruises(Array $params)
	{

		$params = (object)$params;
		$columns = [
				$this->table.'.date',$this->table.'.cruise_night_id', 
				'cruise_nights.nights', 'cruise_nights.vendor_detail_id',
				DB::raw('CONCAT(vendor_details.prefix,vendor_details.id) as vuid'),
				'vendor_details.company_name as name', 'vendor_details.star_rating', 
				'vendor_details.description', 'vendor_details.policy', 
				'vendor_details.contact_number', 'vendor_details.fax_number', 
				'vendor_details.email', 'vendor_details.address', 'vendor_details.pincode', 
				'vendor_details.latitude', 'vendor_details.longitude', 
				'vendor_details.special_instructions' 
			];

		$cruises = $this->select($columns)
					->join(
								'cruise_nights', 'cruise_nights.id', 
								'=', $this->table.'.cruise_night_id'
							)
						->join(
									'vendor_details', 'vendor_details.id',
									'=', 'cruise_nights.vendor_detail_id'
								)
								->with('images', 'cabins')
									->where([
											[$this->table.'.date', '=', $params->date],
											['cruise_nights.nights', '=', $params->nights],
											['vendor_details.destination_code','=', $params->cityId],
										])
										->get();
		return $cruises;
	}


	public function cruiseNights()
	{
		return $this->belongsTo('App\Models\Api\CruiseNightModel', 'cruise_night_id');
	}


	/*=========these function will work only for cruises()=========*/
	public function images()
	{
		return $this->hasMany('App\Models\Api\ImageModel', 'relationId', 'vuid');
	}

	public function cabins()
	{
		$images = $this->images;
		return $this->hasMany('App\Models\Api\CruiseCabinModel', 'vendor_detail_id', 'vendor_detail_id');
	}

}
