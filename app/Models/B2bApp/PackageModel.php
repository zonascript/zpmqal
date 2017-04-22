<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\B2bApp\ItineraryController;
use Carbon\Carbon;
use DB;


class PackageModel extends Model
{
	protected $table = 'packages';
	protected $append = ['uid', 'cost', 'nights', 'pax_detail', 'itinerary'];
	protected $hidden = ['created_at', 'updated_at'];


	public static function call(){
		return new PackageModel;
	}

	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	public function getUidAttribute()
	{
		return $this->prefix.str_pad($this->id, 5, '0', STR_PAD_LEFT);
	}

	public function getNightsAttribute()
	{
		return $this->routes->sum('nights');
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



	/*
	| this function for find package by id but it should be blongs to user 
	| otherwise it should be return null which means id or package is not that user 
	*/
	public function usersFind($id, $colunm = null, $where = [])
	{

		$colunm = is_null($colunm) ? '*' : $colunm;
		
		$where = array_merge(["id" => $id], $where);

		$result  = $this->select($colunm)
											->with('roomGuest')
												->where($where)
													->first();

		return $result;
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
		$costs = $this->hasMany('App\Models\B2bApp\PackageCostModel', 'package_id');
		return $costs->where(["is_current" => 1]);
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


	public function flightRoutes($value='')
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
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
		return $result->where(['mode' => 'hotel']);
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


	public function accomoRoutes()
	{
		$result = $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id');
		return $result->where(function ($query) {
					                $query->orWhere('mode', '=', 'hotel')
					                      ->orWhere('mode', '=', 'cruise');
						            });
	}


	public function fixRouteDates()
	{
		$routes = $this->routes[0]->fixDates();
		return true;
	}



}

