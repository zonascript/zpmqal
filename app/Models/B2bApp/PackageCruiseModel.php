<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCruiseModel extends Model
{
	protected $table = 'package_cruises';

	public static function call(){
		return new PackageFlightModel;
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


  public function book($id){
		DB::update("UPDATE `package_cruises` SET `fgf_cruise_result` = `temp_fgf_cruise_result`, `fgf_cabin_result` = `temp_fgf_cabin_result` WHERE `id` = $id");
	}
}
