<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class AgodaDestinationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'agoda_destinations';

	public static function call()
	{
		return new AgodaDestinationModel;
	}

	public function searchFirst($search){

		$result = $this->select()
										 ->where(['city' => $search])
											->first();

		if (is_null($result)) {
			$result = $this->select()
											->where('city', 'LIKE' , $search)
												->first();
		}
		
		return $result;
	}


	public function search($search){

		$result = $this->select()
										 ->where(['city' => $search])
											->get();

		if ($result->count() == 0) {
			$result = $this->select()
											->where('city', 'LIKE' , $search)
												->get();
		}
		
		return $result;
	}

}
