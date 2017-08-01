<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CommonApp\DestinationController;
use App\Models\HotelApp\AgodaDestinationModel;
use App\Models\CommonApp\DestinationModel;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\AirportModel;
use Carbon\Carbon;


class RouteModel extends Model
{
	protected $table = 'routes';
	protected $appends = [
			'end_datetime',
			'origin_detail', 
			'explode_origin',
			'start_datetime', 
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
		$result = $this->originMorphTo;

		if (is_null($result) || $this->mode == 'flight') {
			$location = $this->location($this->explode_origin);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && $this->mode != 'flight') {
				$this->origin_code = $result->id;
				$this->save();
			}
		}
		
		return $result;
	}


	public function getDestinationDetailAttribute()
	{
		$result = $this->destinationMorphTo;

		if (is_null($result) || $this->mode == 'flight') {
			$location = $this->location($this->explode_destination);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && $this->mode != 'flight') {
				$this->destination_code = $result->id;
				$this->save();
			}
		}
		
		return $result;
	}


	public function originMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->mode == 'flight') {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'origin_code', $col);
	}

	public function destinationMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->mode == 'flight') {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'destination_code', $col);
	}


	public function getOriginCodeAttribute($code)
	{
		if ($this->mode == 'flight' && !strlen($code)) {
			$code = substr($this->attributes['origin'], 0, 3);
			$this->origin_code = $code;
			$this->save();
		}
		return $code;
	}



	public function getDestinationCodeAttribute($code)
	{
		if ($this->mode == 'flight' && !strlen($code)) {
			$code = substr($this->attributes['destination'], 0, 3);
			$this->destination_code = $code;
			$this->save();
		}

		return $code;
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


	public function scopeByPackageUser($query)
	{
		return $query->whereHas('package',function ($q){
											$q->byUser();
										});
	}


	public function scopeByPackageId($query, $pid)
	{
		return $query->where(['package_id' => $pid]);
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



	public function isCorrectUser($id)
	{
		return $this->where(['id' => $id])
									->whereHas('package', function ($q){
												$auth = auth()->user();
												$q->where(['user_id' => $auth->id]);
											})
										->count();
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
			$params = [
							'cityId' => $this->destination_detail->id,
							'nights' => $this->nights
						];
			$result = $this->fusion->cruiseDetail($params);
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


	public function visaDetail()
	{
		$result = null;
		if (in_array($this->mode, ['hotel', 'cruise'])) {
			$result = $this->destination_detail->visaDetail;
		}
		return $result;
	}

}
