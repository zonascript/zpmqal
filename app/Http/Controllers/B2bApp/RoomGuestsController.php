<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==========================B2bApp Controller===========================
use App\Http\Controllers\B2bApp\ChildAgeController;

// ================================Models================================
use App\Models\B2bApp\RoomGuestModel;


class RoomGuestsController extends Controller
{
	public static function call()
	{
		return new RoomGuestsController;
	}


	public function model()
	{
		return new RoomGuestModel;
	}

	/*
	| this function is to save room guest data in db
	| object must be like this 
	| $obj = (object)["noOfAdult" = 2, "childAge" => [2, 5, 9]];
	*/
	public function create($packageDbId, $params)
	{
		$roomGuest = new RoomGuestModel;
		$roomGuest->package_id = $packageDbId;
		$roomGuest->no_of_adult = $params->NoOfAdults;
		$roomGuest->save();

		$childAgeParams = [];
		foreach ($params->ChildAge as $childAge) {
			$childAgeParams[] = addDateColumns([
					'room_guest_id' => $roomGuest->id, 
					'age' => $childAge
				]);
		}

		ChildAgeController::call()->bulkInsert($childAgeParams);	
	}

	/*
	| this function here to save multidi array
	| [
	|		"packageDbId" => 23,
	|		"roomGuest"	=> [ 
	|				["noOfAdult" => 2, "childAge" => [2, 4, 5]],
	|				["noOfAdult" => 2, "childAge" => [2, 4, 5]]
	|		]
	|	]
	*/
	public function createNewMulti($params)
	{	
		// this is for be sure that passed params is object 
		$params = rejson_decode($params);

		foreach ($params->roomGuest as $roomGuest) {
			$this->create($params->packageDbId, $roomGuest);
		}
	}


}
