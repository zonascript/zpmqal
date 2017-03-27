<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =========================Api Controllers========================= 
use App\Http\Controllers\Api\ViatorController;
use App\Http\Controllers\Api\ViatorDestinationController;

// ==============================Model==============================
use App\Models\Api\ViatorActivityModel;



class ViatorActivitiesController extends Controller
{
	public static function call()
	{
		return new ViatorActivitiesController;
	}

	public function model()
	{
		return new ViatorActivityModel;
	}

	public function searchDestination($search = '')
	{
		return ViatorDestinationController::call()->searchDestination($search);
	}

	public function getProduct($params)
	{
		$result = ViatorController::call()->postProduct($params);
		$viatorActivity = new ViatorActivityModel;
		$viatorActivity->destination_id = $params["destId"];
		$viatorActivity->start_date = $params["startDate"];
		$viatorActivity->end_date = $params["endDate"];
		$viatorActivity->currency_code = $params["currencyCode"];
		$viatorActivity->result = $result;
		$viatorActivity->save();

		$result = json_decode($result);
		$result->db = (object)["id" => $viatorActivity->id, "table" => "viator_activities"];
		return $result;
	}


	public function find($id)
	{
		return ViatorActivityModel::find($id);
	}


}
