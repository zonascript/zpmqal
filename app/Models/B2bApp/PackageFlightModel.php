<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class PackageFlightModel extends Model
{
	use CallTrait;

	protected $table = 'package_flights';
	protected $appends = ['flight_details'];


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}


	public function getFlightDetailsAttribute()
	{
		$result = null;
		if ($this->selected_flight_vendor = 'qpx' && !is_null($this->qpxFlight)) {
			$result = $this->qpxFlight->flightDetail();
		}
		elseif ($this->selected_flight_vendor == 'ss' && !is_null($this->ssFlight)) {
			$result = $this->ssFlight->flightDetail();
		}

		return $result;
	}


	/*
	| this function to find hotal's data from db behalf of logged in user or agent
	*/
	public function usersFind($id)
	{
		return $this->select()
									->where(['id' => $id])
										->first();
	}


	/*
	| this function is for getting route then package data 
	| from package table behalf of package_id
	*/
	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');		
	}


	/*
	| this function is to get qpx flight 
	*/
	public function qpxFlight()
	{
		return $this->belongsTo('App\Models\FlightApp\QpxFlightModel', 'qpx_flight_id');		
	}

	/*
	| this function is to get ss flight 
	*/
	public function ssFlight()
	{
		return $this->belongsTo('App\Models\FlightApp\SkyscannerFlightsModel', 'skyscanner_flight_id');
	}




}
