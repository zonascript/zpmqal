<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class ViatorDestinationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'viator_destinations';

	public static function call()
	{
		return new ViatorDestinationModel;
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
