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


	public function setTokenAttribute()
	{
		$this->attributes['token'] = new_token();
	}


	public function getTokenAttribute($value)
	{
		if (!strlen($value)) {
			$this->token = new_token();
			$this->save();
		}
		return $value;
	}


	public function getOriginDetailAttribute()
	{
		$result = $this->originMorphTo;

		if (is_null($result) || $this->checkMode('flight')) {
			$location = $this->location($this->explode_origin);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && !$this->checkMode('flight')) {
				$this->origin_code = $result->id;
				$this->save();
			}
		}
		
		return $result;
	}


	public function getDestinationDetailAttribute()
	{
		$result = $this->destinationMorphTo;

		if (is_null($result) || $this->checkMode('flight')) {
			$location = $this->location($this->explode_destination);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && !$this->checkMode('flight')) {
				$this->destination_code = $result->id;
				$this->save();
			}
		}
		
		return $result;
	}



	public function getOriginCodeAttribute($code)
	{
		if ($this->checkMode('flight') && !strlen($code)) {
			$code = substr($this->attributes['origin'], 0, 3);
			$this->origin_code = $code;
			$this->save();
		}
		return $code;
	}



	public function getDestinationCodeAttribute($code)
	{
		if ($this->checkMode('flight') && !strlen($code)) {
			$code = substr($this->attributes['destination'], 0, 3);
			$this->destination_code = $code;
			$this->save();
		}

		return $code;
	}


	public function getIsDateStaticAttribute()
	{
		return $this->checkMode('flight') ? false : true;
	}


	public function getStartDateAttribute($value)
	{
		return is_null($value) ? '0000-00-00' :$value;
	}

	public function getEndDateAttribute($value)
	{
		return $this->is_date_static 
				 ? $this->start_datetime
									->addDays($this->nights)
										->format('Y-m-d')
				 : $value;
	}	


	public function getStartDatetimeAttribute()
	{
		return Carbon::parse($this->start_date.' '.$this->start_time);
	}


	public function getEndDatetimeAttribute()
	{
		return Carbon::parse($this->end_date.' '.$this->end_time);
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


	// this will default find active statused
	public function scopeByStatus($query, $status = 'active', $match = '=')
	{
		return $query->where('status', $match, $status);
	}


	public function searchDbLocation($word)
	{
		$result = DestinationController::call()->model();
		if ($word != ', ') {
			$result = $result->search($word);
		}
		return $result;
	}
	


	public function originMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->checkMode('flight')) {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'origin_code', $col);
	}

	public function destinationMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->checkMode('flight')) {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'destination_code', $col);
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
		return $activities->byIsActive()->orderBy('date' ,'asc');
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	public function routes()
	{
		return $this->hasMany(RouteModel::class, 'package_id', 'package_id');
	}


	public function roomGuests()
	{
		return $this->hasMany(
											'App\Models\B2bApp\RoomGuestModel',
											'route_room_map_id', 'route_room_map_id'
										);

		/*return $this->hasManyThrough(
											'App\Models\B2bApp\RoomGuestModel',
											'App\Models\B2bApp\RouteRoomMapModel',
											'id', 'route_room_map_id', 'route_room_map_id', 'id'
										);*/
	}


	public function routeRoomMap()
	{
		return $this->belongsTo(
											'App\Models\B2bApp\RouteRoomMapModel',
											'route_room_map_id'
										);
	}


	public function isCorrectUser($id)
	{
		return $this->where(['id' => $id])
									->whereHas('package', function ($q){
												$q->byUser();
											})
										->count();
	}

	// this function must call on current route
	public function fixNextDates()
	{
		if (!$this->id) return false;

		$routes = $this->routes()
							->byStatus('deleted', '<>')
								->where('id', '>', $this->id)
									->get();
		
		$previousRoute = $this;

		foreach ($routes as $key => $route) {
			// if next is also flight the set start date and time
			$route->start_date = $previousRoute->end_date;
			$route->start_time = $previousRoute->end_time;
			if (!$route->checkMode('flight')) {
				$route->end_date = $route->end_date;
				$route->end_time = $route->end_time;
			}
			$route->save();

			if ($route->checkMode('flight')) return true;
			$previousRoute = $route;
		}
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

		if ($this->checkMode('hotel')) {
			//$images = $this->hotel->images();
		}
		elseif ($this->checkMode('cruise')) {
			//$images = $this->cruise->images();
		}
		return $images;
	}

	// if mode is flight then this will return else will null
	public function flightDetail()
	{
		$result = null;

		if ($this->checkMode('flight') && !is_null($this->fusion)) {
			$result = $this->fusion->flightDetail();
		}

		return $result;
	}


	public function hotelDetail()
	{
		$result = null;
		if ($this->checkMode('hotel')  && !is_null($this->fusion)) {
			$result = $this->fusion->hotelDetail();
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
			$result->summary = $this->summaryString($result->name);
		}
		return $result;
	}


	public function cruiseDetail()
	{
		$result = null;
		if ($this->checkMode('cruise') && !is_null($this->fusion)) {
			$params = [
							'cityId' => $this->destination_detail->id,
							'nights' => $this->nights
						];
			$result = $this->fusion->cruiseDetail($params);
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
			$result->summary = $result->name;
		}
		return $result;
	}
	

	public function accomo()
	{
		$result = mydata();

		if ($this->checkMode('hotel') && $this->status != 'active') {
			$result = $this->hotelDetail();
		}
		elseif ($this->checkMode('cruise') && $this->status != 'active') {
			$result = $this->cruiseDetail();
		}
		return $result;
	}


	public function visaDetail()
	{
		$result = null;
		if ($this->checkMode('hotel') || $this->checkMode('hotel')) {
			$result = $this->destination_detail->visaDetail;
		}
		return $result;
	}


	public function summaryString($name)
	{
		$meals = [];
		$string = '';
		$last = '';

		if ($this->is_breakfast) $meals[] = 'breakfast';
		if ($this->is_lunch) $meals[] = 'lunch';
		if ($this->is_dinner) $meals[] = 'dinner';
		
		if (count($meals) > 1) $last = array_pop($meals);
		$string = implode(', ', $meals);
		if (strlen($last)) $string .= ' and '.$last; 
		if (strlen($string)){
			$string = $name.' with '.$string;
		}
		else{
			$string = $name.' - room only';
		}

		return $string.'.';
	}

	public function makeHotelParams($request)
	{
		$maxRating = isset($request->max_rating) 
							 ? $request->max_rating
							 : 5;
		$minRating = isset($request->min_rating) 
							 ? $request->min_rating
							 : 0;

		return [
				"adults" => 2,
				"location" => '',
				"skip" => $request->skip,
				"name" => $request->name,
				"take" => $request->take,
				'max_rating' => $maxRating,
				'min_rating' => $minRating,
				'latitude' => $this->destination_detail->latitude, 
				'longitude' => $this->destination_detail->longitude, 
				"checkOutDate" => $this->end_datetime->format('Y-m-d'),
				"checkInDate" => $this->start_datetime->format('Y-m-d'),
			];
	}

	public function checkMode($mode)
	{
		if ($mode == $this->mode) return true;

		$modes = [
				'flight' 	 => ['flight'],
				'hotel' 	 => ['hotel', 'hotel_only'],
				'cruise' 	 => ['cruise'],
				'activity' => ['hotel', 'activity_only']
			];

		if (isset($modes[$mode])) {
			return in_array($this->mode, $modes[$mode]);
		}

		return false;
	}


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}

}
