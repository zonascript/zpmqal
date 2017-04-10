<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CruisePriceController;

// =============================Models=============================
use App\Models\Api\FgfCruiseModel;
use App\Models\Api\CruiseOnlyDateModel;
use App\Models\Api\FgfCruiseDetailModel;


class CruiseController extends Controller
{

	public static function call()
	{
		return new CruiseController;
	}

	public function cruise($params = [])
	{
		// $params = ["checkInDate" => "2017-01-08","city_id" => "16532","nights" => 5,"adultCount" => 2,"childAge" => [],"minRating" => 1,"maxRating" => 5,"PreferredCurrency" => "INR"];
		
		$paramsTemp = [
				"checkInDate" => null,
				"city_id" => null,
				"nights" => null,
				"adultCount" =>null,
				"childAge" => [], 
				"minRating" => null,
				"maxRating" => null
			];

		$params = array_merge($paramsTemp, $params);
		$result = (object)["cruises" => ""];
		$result->cruises = CruisePriceController::call()->cruise($params);

		$fgfCruise = new FgfCruiseModel;
		$fgfCruise->request = $params;
		$fgfCruise->result = $result;
		$fgfCruise->save();
		$result->db = (object)['id' => $fgfCruise->id];
		return $result;
	}


	public function cruiseCabin($params = [])
	{

		$paramsTemp = [
				"resultIndex" => null,
				"checkInDate" => null,
				"nights" => null,
				"adultCount" =>null,
				"childAge" => [null], 
				"minRating" => null,
				"maxRating" => null
			];

		/*$params = [
				"resultIndex" => 1,
				"checkInDate" => '2016-08-28',
				"nights" => 5,
				"adultCount" =>2,
				"childAge" => [2], 
				"minRating" => 1,
				"maxRating" => 5
			];*/

		$params = array_merge($paramsTemp, $params);

		$result = (object)["cabins" => ""];
		$result->cabins = CruisePriceController::call()->cruiseCabin($params);

		$fgfCruiseDetail = new FgfCruiseDetailModel;
		$fgfCruiseDetail->request = $params;
		$fgfCruiseDetail->result = $result;
		$fgfCruiseDetail->save();
		$result->db = (object)['id' => $fgfCruiseDetail->id];
		return $result;
	}


	public function cruises($params=[])
	{
		$params = ['date' => '2017-04-16', 'cityId' => '16532', 'nights' => '5'];

		$cruises = CruiseOnlyDateModel::call()->cruises($params);

		dd_pre_echo(rejson_decode($cruises));

	}
}
