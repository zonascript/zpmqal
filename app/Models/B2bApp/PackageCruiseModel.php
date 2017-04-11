<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\CruiseOnlyDateModel;

class PackageCruiseModel extends Model
{
	protected $table = 'package_cruises';
	protected $appends = ['detail'];

	public static function call(){
		return new PackageFlightModel;
	}


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}


	
	/*
	| this function is for getting route of that route
	*/
	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');		
	}



	/*
	| this function is for getting route of that route
	*/
	public function fgfCruise()
	{
		return $this->belongsTo('App\Models\Api\FgfCruiseModel', 'fgf_cruise_id');		
	}


	public function fgfTempCruise()
	{
		return $this->belongsTo('App\Models\Api\FgfCruiseModel', 'fgf_temp_cruise_id');		
	}


	public function cabin()
	{
		return $this->belongsTo('App\Models\Api\CruiseCabinModel', 'cruise_cabin_id');
	}

	public function detail()
	{
		$params = [
				'date' => $this->route->start_date, 
				'vendor_detail_id' => $this->cabin->vendor_detail_id, 
				'nights' => $this->route->nights
			];

		$result = CruiseOnlyDateModel::call()->detail($params);
		return $result;
	}

	public function itinerary()
	{
		$result = $this->detail();
		return $result->itinerary;
	}

	public function getDetailAttribute()
	{
		$roomType  = isset($this->cabin->cabin) ? $this->cabin->cabin : '';
		$result = (object)[
				"code" => '',
				"vendor" => '',
				"name" => '',
				"nights" => $this->route->nights,
				"location" => $this->route->destination_detail->location,
				"endDate" => $this->route->end_datetime->format('d-M-Y'),
				"startDate" => $this->route->start_datetime->format('d-M-Y'),
				"roomType" => $roomType,
				"address" => '',
				"image" => '',
				"address" => '',
				"starRating" => '',
				"starRatingHtml" => '',					
				"description" => '',
				"shortDescription" => '',
				"htmlDescription" => '',
			];

		if ($this->selected_cruise_vendor == 'fgf') {
			$result->vendor = 'fgf';
			$detail = $this->detail();
			$result->code = $detail->vendor_detail_id;
			$result->name = proper($detail->name);
			$result->image = isset($detail->images[0]->url)
										 ? $detail->images[0]->url
										 : urlDefaultImageCruise();
			$result->address = $detail->address;
			$result->description = $detail->description;
			$result->starRating = $detail->star_rating;
			$result->htmlDescription = $detail->description;
		}

		$result->starRatingHtml = getStarImage($result->starRating, 15, 15);
		$result->shortDescription = sub_string($result->description, 120);

		return $result;
	}



	public function images()
	{
		$images = [];
		$detail = $this->detail();
		foreach ($detail->images as $image) {
			$images[] = $image->url;
		}
		return $images;
	}
}
