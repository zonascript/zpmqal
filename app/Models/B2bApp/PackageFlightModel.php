<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class PackageFlightModel extends Model
{
	protected $table = 'package_flights';

	public static function call(){
		return new PackageFlightModel;
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
		return $this->belongsTo('App\Models\Api\QpxFlightModel', 'qpx_flight_id');		
	}

	/*
	| this function is to get ss flight 
	*/
	public function ssFlight()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerFlightsModel', 'skyscanner_flight_id');
	}

}
