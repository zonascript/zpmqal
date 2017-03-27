<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class DestinationModel extends Model
{
  protected $connection = 'mysql2';
	protected $table = 'destinations';

	public static function call(){
		return new DestinationModel;
	}


	public function search($value)
	{
		return $this->select()
									->where([
												['status', '=', 'active'], 
												['destination', 'LIKE', '%'.$value.'%']
											])
										->get();
	}


	public function findByDestination($value)
	{
		return $this->select()
									->where([
												['status', '=', 'active'], 
												['destination', 'LIKE', '%'.$value.'%']
											])
										->first();
	}

	public function searchName($value)
	{
		$result = $this->select(DB::raw("CONCAT(destination, ', ',  country) AS location"))
						->where([
									[$this->table.'.status', '=', 'active'], 
									[$this->table.'.destination', 'LIKE', '%'.$value.'%']
								])
						->get();

		return $result;
	}


	public function viatorDestination()
	{
		return $this->hasOne('App\Models\BackendApp\ViatorDestinationModel', 'destinationName', 'destination');
	}


	public function activities()
	{
		return $this->hasMany('App\Models\BackendApp\ActivityModel', 'destinationCode', 'fgf_destinationcode');
	}

}
