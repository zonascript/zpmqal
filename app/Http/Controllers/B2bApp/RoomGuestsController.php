<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\RoomGuestModel;
use App\Http\Controllers\B2bApp\ChildAgeController;


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
	public function create($pid, $params)
	{
		$roomGuest = new RoomGuestModel;
		$roomGuest->package_id = $pid;
		$roomGuest->no_of_adult = $params->NoOfAdult;
		$roomGuest->save();

		$childAgeParams = [];
		foreach ($params->ChildAge as $childAge) {
			$childAgeParams[] = addDateColumns([
					'room_guest_id' => $roomGuest->id, 
					'age' => $childAge
				]);
		}

		ChildAgeController::call()->model()->insert($childAgeParams);	
	}


	/*
	| this function here to save multidi array
	|		$roomGuests = [ 
	|				["NoOfAdult" => 2, "ChildAge" => [2, 4, 5]],
	|			];
	*/
	public function createNewMulti($pid, $roomGuests)
	{	
		// this is for be sure that passed params is object 
		$roomGuests = rejson_decode($roomGuests);
		foreach ($roomGuests as $roomGuest) {
			$this->create($pid, $roomGuest);
		}
	}


	public function createOrUpdate($id, Request $request)
	{
		$roomGuest = $this->model()->find($id);

		if (is_null($roomGuest)) {
			$roomGuest = $this->model();
		}

		$roomGuest->rooms = $request->rooms;
		$roomGuest->package_id = $request->package_id;
		$roomGuest->no_of_adult = $request->no_of_adult;
		$roomGuest->save();
		$ids = [];

		foreach ($request->children_age as $childAge) {
			$data = new Request([
								'room_guest_id' => $roomGuest->id, 
								'age' => $childAge['age']
							]);
			$child = ChildAgeController::call()
							->createOrUpdate($childAge['id'], $data);
			$ids[] = $child->id;
		}

		$roomGuest->childAge()->notInIds($ids)->delete();
		return $roomGuest;
	}


	public function destroy($id)
	{
		$roomGuest = $this->model()->byUser()->find($id);
		$roomGuest->childAge()->delete();
		return $roomGuest->delete();
	}


}
