<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class PackageHotelModel extends Model
{
	protected $table = 'package_hotels';

	protected $casts = [
			'request' => 'object',
			'result' => 'object'
		];


	public static function call(){
		return new PackageHotelModel;
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
	| this function is for getting route of that route
	*/
	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');		
	}


	/*
	| this function is for getting package data 
	| from package table behalf of package_id
	*/
	public function tbtqHotel()
	{
		return $this->belongsTo('App\Models\Api\TbtqHotelModel', 'tbtq_hotel_id');		
	}



	public function skyscannerHotel()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerHotelModel', 'skysacanner_hotel_id');
	}


	public function agodaHotel()
	{
		return $this->belongsTo(
											'App\Models\Api\AgodaHotelModel', 
											'agoda_hotel_id', 'hotel_id'
										);
	}


	public function activities()
	{
		return $this->hasOne('App\Models\B2bApp\PackageActivityModel', 'package_hotel_id')
									->with('fgf')
										->with('viator');		
	}




}
