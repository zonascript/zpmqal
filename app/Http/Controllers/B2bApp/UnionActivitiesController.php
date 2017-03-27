<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ============================Api Controller============================
use App\Http\Controllers\Api\ActivityController;

// ================================Models================================
use App\Models\Api\UnionActivityModel;

class UnionActivitiesController extends Controller
{
	public static function call()
	{
		return new UnionActivitiesController;
	}


	public function activities($params)
	{
		$result = ActivityController::call()->model()->unionActivities($params);
		$unionActivities = new UnionActivityModel;
		$unionActivities->request = $params;
		$unionActivities->result = $result;
		$unionActivities->save();
		$result->db = (object)['id' => $unionActivities->id];
		return $result;
	}

}
