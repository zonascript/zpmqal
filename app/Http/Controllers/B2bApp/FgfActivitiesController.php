<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ============================Api Controller============================
use App\Http\Controllers\Api\ActivityController;

// ================================Models================================
use App\Models\Api\FgfActivityModel;

class FgfActivitiesController extends Controller
{

	public static function call()
	{
		return new FgfActivitiesController;
	}


	public function api()
	{
		return new ActivityController;
	}

	/*
	| this function is to get all activities of the destination and date
	*/
	public function activities($cityId, $date){
		$result = ActivityController::call()->getActivities($cityId, $date);
		$result = json_encode($result);

		$fgfActivityModel = new FgfActivityModel;
		$fgfActivityModel->city_id = $cityId;
		$fgfActivityModel->date = $date;
		$fgfActivityModel->result = $result;
		$fgfActivityModel->save();
		$result = json_decode($result);
		
		if (!is_object($result)) {
			$result = (object)[];
		}

		$result->db = (object)["id" => $fgfActivityModel->id];
		return $result;
  }

}
