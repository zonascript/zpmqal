<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\BackendApp\ViatorActivityModel;
use DB;

class ActivityModel extends Model
{
	protected $table = 'activities';
	protected $connection = 'mysql2';
	protected $append = ['uid'];
	
	public static function call()
	{
		return new ActivityModel;
	}

	public function getUidAttribute()
	{
		return $this->attributes['prefix'].$this->attributes['id'];
	}

	public function destination()
	{
		return $this->hasOne('App\Models\BackendApp\DestinationModel', 'fgf_destinationcode', 'destinationCode');
	}


	public function findByDestination($destinationCode)
	{
		return $this->select()
									->where([
												'status' => 'active',
												'destinationCode' => $destinationCode
											])
										->get();
	}


	public function allByUnionPage($params)
	{

		$fgfActivity = DB::connection('mysql2')->table('activities')
									->select([
												'id', DB::raw('\'f\' as vendor'), 
												'destinationCode', 'currency', 'name', 
												'description', 'status', 'rank'
											])
										->where(['destinationCode' => $params->fgfDestinationCode]);


		$finalActivities = DB::connection('mysql2')->table('viator_activities')
											->select([
															'id', DB::raw('\'v\' as vendor'), 
															'primaryDestinationId as  destinationCode', 
															'currencyCode as currency', 
															'title as name', 
															'shortDescription as  description', 
															'status', 'rank'
														])
													->where(['primaryDestinationId' => $params->viatorDestinationCode])
														->unionAll($fgfActivity)
															->orderBy('rank', 'desc')
																	->simplePaginate(25);
																			// ->get();
		// dd($finalActivities);
		return $finalActivities;
	}

}
