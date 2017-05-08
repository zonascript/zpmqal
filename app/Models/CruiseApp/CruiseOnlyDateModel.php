<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class CruiseOnlyDateModel extends Model
{
	protected $connection = 'mysql5';
	protected $table = 'cruise_only_dates';
	protected $appends = ['vendor'];
	protected $hidden = ['created_at', 'updated_at'];
	public $params = [];

	public static function call()
	{
		return new CruiseOnlyDateModel;
	}

	public function getVendorAttribute()
	{
		return 'f';
	}


	public function cruises(Array $params)
	{
		$params = (object) $params;

		$cruises = $this->where('date', $params->date)
					->with('cruiseNights', 'cruiseNights.vendorDetail')
						->whereHas('cruiseNights', function($q) use ($params) {
								$q->where('nights','=', $params->nights)
										->whereHas('vendorDetail', function($q) use ($params) {
												$q->where('destination_code', $params->cityId);
											});
								})
							->skip(0)
								->take(25)
									->get();
		return $cruises;
	}


	public function cruiseFormatted(Array $params)
	{
		$cruises = $this->cruises($params);
		$result = [];
		foreach ($cruises as $cruise) {
			if (isset($cruise->cruiseNights->vendorDetail->company_name)) {
				$vendorDetail = $cruise->cruiseNights->vendorDetail;
				$images = isset($vendorDetail->images[0]->url)
								? $vendorDetail->images[0]->url
								: urlDefaultImageCruise();

				$result[] = (object)[
						"id" => $cruise->id, // this is cruise_only_dates -> id 
						"name" => $vendorDetail->company_name,
						"city" => $vendorDetail->destination->destination,
						"image"	=> $images,
						"vendor" => $cruise->vendor,
						"address"	=> $vendorDetail->address,
						"country"	=> $vendorDetail->destination->country,
						"latitude" =>	$vendorDetail->latitude,
						"longitude" => $vendorDetail->longitude,
						"description" => $vendorDetail->description,
						"star_rating" => $vendorDetail->star_rating,
					];
			}
		}
		return $result;
	}


	public function cruiseCabinsWithImages($id)
	{
		$cruise = $this->find($id);
		$images = [];
		$imagesResult = isset($cruise->cruiseNights->vendorDetail->images)
									? $cruise->cruiseNights->vendorDetail->images
									: [];

		foreach ($imagesResult as $image) {
			$images[] = $image->url;
		}
		
		
		$cabinsResult = isset($cruise->cruiseNights->vendorDetail->cabins)
									? $cruise->cruiseNights->vendorDetail->cabins
									: [];
		$cabins = [];
		$count = 0;
		foreach ($cabinsResult as $cabinKey => $cabin) {
			
			if ($cabinKey == count($images)) $count = 0;

			$image = $images[$count];
			$cabins[] = [
					"id" => $cabin->id,
					"vdr" => $cabin->vendor,
					"image" => $image,
					"cabintype" => $cabin->cabintype,
				];
			$count++;
		}
		return ["cabins" => $cabins, "images" => $images];
	}


	public function cruiseNights()
	{
		return $this->belongsTo(
											'App\Models\CruiseApp\CruiseNightModel', 
											'cruise_night_id'
										);
	}


	public function itinerary()
	{
		return $this->hasMany(
											'App\Models\CruiseApp\CruiseItineraryModel', 
											'cruise_night_id', 'cruise_night_id'
										);
	}

}
