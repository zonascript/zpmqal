<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class AirportModel extends Model
{
	protected $connection = 'mysql2';

	public static function call()
	{
		return new AirportModel;
	}

	public function getAirport($search){

		return DB::connection('mysql2')->select(
							DB::raw("SELECT CONCAT(`airport_code`, ', ', `city`, ', ', `country`) AS `airports` FROM `airports` WHERE CONCAT(`airport_code`, ', ', `city`, ', ', `country`) LIKE '%$search%'")
				);
	}

	public function getLocation($search)
	{
		$result = DB::connection('mysql2')->select(
			DB::raw("SELECT CONCAT(a.`airport_code`, ', ', a.`airport_name`, ', ' , a.`city`, ', ', a.`country`,' | ', d.`destination`, ', ', d.`country`) AS `airports` FROM `airports` a JOIN `destinations` d ON d.`country_code` LIKE a.`country_code` AND d.`destination` LIKE a.`city` OR a.`city` LIKE d.`destination` WHERE a.`airport_code` = '$search' OR CONCAT(a.`airport_code`, ', ', a.`airport_name`, ', ', a.`city`, ', ', a.`country`) LIKE '%$search%' OR CONCAT(a.`airport_code`, ' ', a.`airport_name`, ' ', a.`city`, ' ', a.`country`) LIKE '%$search%'")
		);
		
		return $result;
	}

	/*
	| this function is return and array
	| ["Airport_Code, Airport_Name, Destination_Or_City_Name, Country_Name"]
	*/
	public function getAirportAndLocation($search)
	{
		$sqlQuery = (
			"SELECT CONCAT
			  (
			    a.`airport_code`, ', ',
			    a.`airport_name`, ', ',
			    IFNULL(d.`destination`, a.`city`),  ', ',
			    IFNULL(d.`country`, a.`country`)
			  ) AS `airports`
			FROM
			  `airports` a
			LEFT JOIN
			  `destinations` d 
			  ON d.`country_code` = a.`country_code` 
			  AND (d.`destination` LIKE a.`city` OR a.`city` LIKE d.`destination`)
			WHERE "
		);

		if (strlen($search) <= 3) {
			$sqlQuery .= "a.`airport_code` = '$search'";
		}
		else{
			$sqlQuery .= (
				"CONCAT(
			    a.`airport_code`,', ',
			    a.`airport_name`,', ',
			    a.`city`,', ',
			    a.`country`
			  ) LIKE '%$search%' 

				OR CONCAT(
				  a.`airport_code`,' ',
				  a.`airport_name`,' ',
				  a.`city`,' ',
				  a.`country`
				) LIKE '%$search%'"
			);
		}
		$result = DB::connection('mysql2')->select(DB::raw($sqlQuery));
		return $result;
	}

	

}
