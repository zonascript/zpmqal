<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;

class ViatorDestinationModel extends Model
{
	protected $connection = 'mysql6';
	protected $table = 'viator_destinations';

	public static function call()
	{
		return new ViatorDestinationModel;
	}


	public function activities()
	{
		return $this->hasMany('App\Models\BackendApp\ViatorActivityModel', 'primaryDestinationId', 'destinationId');
	}

	
	public function searchDestiantion($search='')
	{
		$result = $this::select()
				 					 ->where(['destinationName' => $search])
				 					 ->get();

		if ($result->count() == 0) {
			$result = $this::select()
									->where('destinationName', 'LIKE' , $search)
									->get();
		}
		
		return $result;
	}

}
