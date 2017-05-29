<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class TravelportHotelModel extends Model
{
	protected $connection  = 'mysql4';
	protected $table = 'travelport_hotels';

	public static function call()
	{
		return new TravelportHotelModel;
	}

	public function insertIgnore(Array $array)
	{
		$query = '';
		$isMulti = false;

		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$query .= insertIgnoreQuery($value, $this->table);
				$isMulti = true;
			}
			else{
				break;
			}
		}

		if (!$isMulti) {
			$query .= insertIgnoreQuery($array, $this->table);
		}

		return DB::connection($this->connection)->unprepared($query);
	}
}
