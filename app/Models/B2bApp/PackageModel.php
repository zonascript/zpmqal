<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\B2bApp\ItineraryController;
use App\Models\B2bApp\PackageActivityModel;
use App\Models\B2bApp\PackageModel;
use Carbon\Carbon;
use DB;


class PackageModel extends Model
{
	protected $table = 'packages';
	protected $hidden = ['created_at', 'updated_at'];
	protected $append = [
								'uid', 'cost', 'nights', 'pax_detail',
								'pax_string', 'itinerary', 'package_url',
								'extra_word', 'duration'
							];

	public $costToken = null;

	public static function call(){
		return new PackageModel;
	}

	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	public function setTokenAttribute()
	{
		$this->attributes['token'] = mycrypt($this->count());
	}

	public function getTokenAttribute($value)
	{
		if (is_null($value)) {
			$this->setTokenAttribute();
			$this->save(); 
		}
		return $value;
	}

	public function getUidAttribute()
	{
		$prefix = $this->client->user->admin->prefix;
		$uid = $prefix.str_pad($this->package_code, 7, '0', STR_PAD_LEFT);
		if ($this->modify_count) {
			$uid .= '-'.num2alpha($this->modify_count-1);
		}
		return $uid; 
	}

	public function getNightsAttribute()
	{
		return $this->routes->sum('nights');
	}

	public function getDurationAttribute()
	{
		return $this->nights.' Nights '.($this->nights+1).'Days';
	}


	public function getStartDateAttribute($value)
	{
		return Carbon::parse($value);
	}

	public function getEndDateAttribute()
	{
		$startDate = $this->start_date;
		$startDate->addDays($this->nights);
		return $startDate;
	}

	public function getItineraryAttribute()
	{
		return ItineraryController::call()->itinerary($this);
	}


	public function getExtraWordAttribute()
	{
		$text = null;
		if (!is_null($this->packageNote)) {
			$text = $this->packageNote->note;
		}
		return $text;
	}


	public function getPackageUrlAttribute()
	{
		$url = null;
		if (isset($this->cost->token) && $this->cost->total_cost) {
			$url = route('yourPackage', $this->attributes['token']).'?ctk='.$this->cost->token;
		}
		return $url;
	}

	public function getPaxDetailAttribute()
	{
		$roomGuest = $this->roomGuest;
		$result = ["adult" => 0, "child" => 0, "infant" => 0];
		
		foreach ($roomGuest as $key => $value) {
			$result['adult'] += $value->no_of_adult;
			foreach ($value->childAge as $childAge) {
				if ($childAge->age <= 2) {
					$result['infant'] += 1;
				}else{
					$result['child'] += 1;
				}
			}
		}

		return (object) $result;
	}

	public function getPaxStringAttribute()
	{
		$pax = $this->pax_detail;

		$result = [];
		if (isset($pax->adult) && $pax->adult) {
			$result[] = $pax->adult.' '.str_plural('Adult', $pax->adult);
		}

		if (isset($pax->child) && $pax->child) {
			$result[] = $pax->child.' '.str_plural('Child', $pax->child);
		}

		if (isset($pax->infant) && $pax->infant) {
			$result[] = $pax->infant.' '.str_plural('Infant', $pax->infant);
		}

		return implode(', ', $result);
	}


	public function modifiedCount($code)
	{
		return $this->where('package_code', $code)->count();
	}


	public function findOrExit($id)
	{
		$package = $this->find($id);
		if (is_null($package)) {
			$this->exitView();
		}
		return $package;
	}


	public function findByToken($token)
	{
		$auth = auth()->user();
		$where = ['token' 	=> $token];
		
		if (!is_null($auth)) {
			$where['user_id'] = $auth->id;
		}

		return $this->where($where)->first();
	}


	public function findByTokenOrExit($token, $next_auth = true)
	{
		$result = $this->findByToken($token);
		
		if (is_null($result)) {
			exitView();
		}

		return $result;
	}

	public function exitView()
	{
		$blade = ["url" => urlReport()];
		exit(view('b2b.protected.dashboard.404_main', $blade)->render());
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');		
	}


	public function roomGuest()
	{
		return $this->hasMany('App\Models\B2bApp\RoomGuestModel', 'package_id')->with('childAge');
	}


	public function client()
	{
		return $this->belongsTo('App\Models\B2bApp\ClientModel', 'client_id');		
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function routes()
	{
		$routes = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $routes->where([['status', '<>', 'deleted']]);
	}

	public function packages()
	{
		return $this->hasMany('App\Models\B2bApp\PackageModel',
											'package_code',
											'package_code'
										);
	}


	public function packageNote()
	{
		return $this->belongsTo(
											PackageNoteModel::class,
											'package_note_id'
										);
	}

	public function copyRoomGuests($pid)
	{
		foreach ($this->roomGuest as $roomGuest) {
			$roomGuest->copyGuests($pid);
		}
		return $this;
	}


	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function getCostAttribute()
	{
		$cost = null;
	
		if ($this->tempCost->count()) {
			$cost = $this->tempCost[0];
		}
		return $cost;
	}


	public function tempCost($value='')
	{
		$where = is_null($this->costToken) 
					 ? ["is_current" => 1]
					 : ["token" => $this->costToken];
		$costs = $this->hasMany('App\Models\B2bApp\PackageCostModel', 'package_id');
		return $costs->where($where);
	}

	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function costs()
	{
		$result = $this->hasMany('App\Models\B2bApp\PackageCostModel', 'package_id');
		return $result->where([['net_cost', '>', 0]]);
	}



	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function cars()
	{
		$cars = $this->hasMany('App\Models\B2bApp\PackageCarModel', 'package_id');
		return $cars->where(["status" => "complete"]);
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeFlightRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(['mode' => 'flight', 'status' => 'active']);
	}


	public function flightRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
						->select('*', DB::raw("'".$this->package_lock_id.'\' as package_lock_id'));
		return $result->where(['mode' => 'flight', ['status', '<>', 'deleted']]);
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeHotelRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(['mode' => 'hotel', 'status' => 'active']);
	}


	public function hotelRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(['mode' => 'hotel',  ['status', '<>', 'deleted']]);
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeCruiseRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(['mode' => 'cruise', 'status' => 'active']);
	}


	public function cruiseRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(['mode' => 'cruise']);
	}

	public function activeAccomoRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where([['status', '=', 'active']])
										->where(function ($query) {
												$query->orWhere('mode', '=', 'hotel')
															->orWhere('mode', '=', 'cruise');
											});
	}

	public function accomoRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where([['status', '<>', 'deleted']])
										->where(function ($query) {
												$query->orWhere('mode', '=', 'hotel')
															->orWhere('mode', '=', 'cruise');
											});
	}


	public function fixRouteDates()
	{
		$routes = $this->routes[0]->fixDates();
		return true;
	}


	public function activities()
	{
		$result = $this->hasManyThrough(
								'App\Models\B2bApp\PackageActivityModel', 
								'App\Models\B2bApp\RouteModel', 
								'package_id', 'route_id', 'id'
							);
		return $result->orderBy('date', 'asc');
	}


	public function createRouteUrl()
	{
		return route('createRoute', [$this->client->token, $this->token]);
	}

	

	public function clientEmailSubject()
	{
		return 'Your package is ready!!! | '.$this->uid;
	}


	public function destinations()
	{
		$dests = [];
		foreach ($this->accomoRoutes as $accomoRoute) {
			$dests[] = $accomoRoute->destination_detail->echo_location;
		}
		return implode(' | ', $dests);
	}

	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}

}

