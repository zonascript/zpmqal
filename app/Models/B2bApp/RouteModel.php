<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

// ===============================Controller=============================== 
use App\Http\Controllers\CommonApp\DestinationController;

// ===============================Model=============================== 
use App\Models\HotelApp\AgodaDestinationModel;
use Carbon\Carbon;


class RouteModel extends Model
{
	protected $table = 'routes';
	protected $appends = [
			'origin_code', 
			'end_datetime',
			'origin_detail', 
			'explode_origin',
			'start_datetime', 
			'destination_code',
			'destination_detail',
			'explode_destination',
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

	public function getOriginDetailAttribute()
	{
		$location = $this->location($this->explode_origin);
		return $this->searchDbLocation($location);
	}


	public function getDestinationDetailAttribute()
	{
		$location = $this->location($this->explode_destination);
		return $this->searchDbLocation($location);
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

	public function getExplodeOriginAttribute()
	{
		return explode(', ', $this->origin);
	}

	public function getExplodeDestinationAttribute()
	{
		return explode(', ', $this->destination);
	}

	public function searchDbLocation($word)
	{
		$result = DestinationController::call()->model();
		if ($word != ', ') {
			$result = $result->search($word);
		}
		return $result;
	}
	

	public function fusion()
	{
		return $this->morphTo();
	}


	public function fusionCount($fusionId)
	{
		return $this->where(['fusion_id' => $fusionId])->count();
	}


	public function location(Array $array)
	{
		$country = '';
		$destination = '';

		if (count($array) > 1) {
			$country = end($array);
			$destination = $array[count($array) - 2];
		}

		return $destination.', '.$country;
	}

	// if copying route then copy package activities too
	public function packageActivities()
	{
		$activities = $this->hasMany(
											'App\Models\B2bApp\PackageActivityModel', 
											'route_id'
										);
		return $activities->orderBy('date' ,'asc');
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
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

		$routes = $this->where($where)->get();
		
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
			//$images = $this->hotel->images();
		}
		elseif ($this->mode = 'cruise') {
			//$images = $this->cruise->images();
		}
		return $images;
	}

	// if mode is flight then this will return else will null
	public function flightDetail()
	{
		$result = null;

		if ($this->mode == 'flight' && !is_null($this->fusion)) {
			$result = $this->fusion->flightDetail();
		}

		return $result;
	}



	public function hotelDetail()
	{
		$result = null;
		if ($this->mode == 'hotel' && !is_null($this->fusion)) {
			$result = $this->fusion->hotelDetail();
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
		}
		return $result;
	}

	public function cruiseDetail()
	{
		$result = null;
		if ($this->mode == 'cruise' && !is_null($this->fusion)) {
			$result = $this->fusion->cruiseDetail();
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
		}
		return $result;
	}

	public function accomo()
	{
		$result = null;
		if ($this->mode == 'hotel') {
			$result = $this->hotelDetail();
		}
		elseif ($this->mode == 'cruise') {
			$result = $this->cruiseDetail();
		}
		return $result;
	}

}
