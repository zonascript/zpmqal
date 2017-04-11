<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

// ===============================Controller=============================== 
use App\Http\Controllers\Api\GoogleMapController;
use App\Http\Controllers\B2bApp\DestinationController;
use App\Models\Api\AgodaDestinationModel;
use Carbon\Carbon;


class RouteModel extends Model
{
	protected $table = 'routes';

	protected $appends = [
			'geo_code',
			'origin_code', 
			'end_datetime',
			'origin_detail', 
			'start_datetime', 
			'location_hotel',
			'location_viator', 
			'destination_code',
			'destination_agoda',
			'destination_detail'
		];
	
	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	public function getLocationHotelAttribute()
	{
		return DestinationController::call()->search($this->attributes['destination']);
	}

	public function getOriginDetailAttribute()
	{
		return DestinationController::call()->search($this->attributes['origin']);
	}

	public function getDestinationDetailAttribute()
	{
		return DestinationController::call()->search($this->attributes['destination']);
	}

	public function getLocationViatorAttribute()
	{
		$destination = $this->location_hotel->destination;
		return DestinationController::call()->viatorSearch($destination);
	}

	public function getDestinationAgodaAttribute()
	{
		$destination = $this->location_hotel->destination;
		return AgodaDestinationModel::call()->searchFirst($destination);
	}

	public function getGeoCodeAttribute()
	{
		return GoogleMapController::call()->geoCode($this->attributes['destination']);
	}


	public function getOriginCodeAttribute()
	{
		$originCode = null;
		
		if ($this->attributes['mode'] == 'flight') {
			$originCode = substr($this->attributes['origin'], 0, 3);
		}
		return $originCode;
	}


	public function getDestinationCodeAttribute()
	{
		$destinationCode = null;

		if ($this->attributes['mode'] == 'flight') {
			$destinationCode = substr($this->attributes['destination'], 0, 3);
		}
		return $destinationCode;
	}


	public function getStartDatetimeAttribute()
	{
		$startDateTime = $this->attributes['start_date'].' '.
										 $this->attributes['start_time'];

		return Carbon::parse($startDateTime);
	}


	public function getEndDatetimeAttribute()
	{
		// $startDate = $this->start_datetime;
		$endDateTime = $this->attributes['end_date'].' '.
									 $this->attributes['end_time'];

		return $endDate = Carbon::parse($endDateTime);
		/*$endDate = Carbon::parse($endDateTime);
		$startDate->addDays($this->attributes['nights']);
		$startDate->hour = $endDate->hour;
		$startDate->minute = $endDate->minute;
		$startDate->second = $endDate->second;
		
		return $startDate;*/
	}


	// public function getStartDateAttribute()
	// {
	// 	return $this->start_datetime;
	// }

	// public function getEndDateAttribute()
	// {
	// 	$endDate = $this->attributes['end_date'];
	// 	if (in_array($this->attributes['mode'], ['hotel', 'land', 'road'])) {
	// 		$endDate = $this->end_datetime;
	// 	}
	// 	return $endDate;
	// }


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	/*
	| this function is to get all flights which is belongs to this package
	*/
	public function flight()
	{
		return $this->hasOne('App\Models\B2bApp\PackageFlightModel', 'route_id');
	}


	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function hotel()
	{
		return $this->hasOne('App\Models\B2bApp\PackageHotelModel', 'route_id');
	}



	/*
	| this function is to get all cruises which is belongs to this package
	*/
	public function cruise()
	{
		return $this->hasOne('App\Models\B2bApp\PackageCruiseModel', 'route_id');
	}



	public function activities()
	{
		return $this->hasOne('App\Models\B2bApp\PackageActivityModel', 'route_id');
	}



	/*
	| this function is to fix date 
	| like every date is invalid when making package
	| need to be fix and if in package has flight the 
	| it is possiblity to dates can be change
	*/
	public function fixDates($routeId=null)
	{
		$routes = null;
		$where = [
				['status', '<>', 'deleted'], 
				['package_id', '=', $this->package_id]
			];

		if (!is_null($routeId)) { 
			$where[] = ['id', '>', $routeId];
		}

		$routes = $this->select()->where($where)->get();
		
		if ($routes->count()) {
			$nextStartDate = '0000-00-00';

			foreach ($routes as $key => $route) {

				if ($key) {
					$route->start_date = $nextStartDate;
				}
				else{
					if ($routeId) {
						$route->start_date = $this->end_date;
					}else{
						$route->start_date = $this->package->start_date;
					}
				} // <- this is for every mode route
				
				if (in_array($route->mode, ['ferry', 'hotel', 'road', 'cruise', 'train'])) {
					$endDate = Carbon::parse($route->start_date);
					$endDate->addDays($route->nights);
					$nextStartDate = $endDate->format('Y-m-d');
					$route->end_date = $nextStartDate;
				}
				
				$route->save();

				if ($route->mode == 'flight') { return true; }
			}
		}
	}

	public function images()
	{
		$images = [];

		if ($this->mode == 'hotel') {
			$images = $this->hotel->images();
		}
		elseif ($this->mode = 'cruise') {
			$images = $this->cruise->images();
		}

		return $images;
	}

}
