<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===========================Model===========================
use App\Models\Api\QpxLimitModel;
use App\Models\Api\QpxFlightModel;

class QpxFlightApiController extends Controller
{
	public $solutions = 250;
	protected $key = '';
	protected $qpxUrl = "https://www.googleapis.com/qpxExpress/v1/trips/search?key=";

	public static function call()
	{
		return new QpxFlightApiController;
	}


	public function flights($packageFlight)
	{
		$flights = [];

		$params = [
				"request" => [
					"slice" => [
						[
							"origin" => $packageFlight->route->origin_code,
							"destination" => $packageFlight->route->destination_code,
							"date" => $packageFlight->route->start_datetime->format('Y-m-d'),
						]
					],
					"passengers" => [
						"adultCount" => $packageFlight->route->package->pax_detail->adult,
						"infantInLapCount" => $packageFlight->route->package->pax_detail->infant,
						"infantInSeatCount" => 0,
						"childCount" => $packageFlight->route->package->pax_detail->child,
						"seniorCount" => 0
					],
					"solutions" => $this->solutions,
					"refundable" => false
				]
			];

		if ($this->key != '') {
			$flights = $this->postFlight($params);
		}

		return $flights;
	}


	/*
	| this function for getting flight result using http post request  
	*/
	public function postFlight($params = []){
		// saving key here
		$this->saveKey();
		// dd($this->key);
		$url = $this->qpxUrl.$this->key;

		$paramsTemp = [
			"request" => [
				"slice" => [
					[
						"origin" => null,
						"destination" => null,
						"date" => null,
					]
				],
				"passengers" => [
					"adultCount" => null,
					"infantInLapCount" => null,
					"infantInSeatCount" => 0,
					"childCount" => null,
					"seniorCount" => 0
				],
				"solutions" => null,
				"refundable" => false
			]
		];

		$params = array_merge($paramsTemp, $params);

		// =============================responce=============================
		$gotResult = false;
		for ($i=0; $i < 5; $i++) { 
			// breaking loop here is got responce
			if ($gotResult) {
				break;
			}

			// getting result here
			$result = $this->httpPost($this->qpxUrl, $params); // only 50 post can be do in a day
			// $result = file_get_contents(storage_path('faker/qpx.json'));
			// if got result then making true this variable
			if ($result != '' && !is_null($result)) {
				$gotResult = true;
			}
		}
		// ====================Saving responce in the db=====================
		
		$result = json_decode($result);

		$qpxFlightModel = new QpxFlightModel;
		$qpxFlightModel->request = $params;
		$qpxFlightModel->result = $result;
		$qpxFlightModel->save();
		
		if (isset($result->trips)) {
			$result->cities = $qpxFlightModel->cities;
			$result->airlines = $qpxFlightModel->airlines;
		}

		if (is_null($result)) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)["id" => $qpxFlightModel->id];
		return $result;
	}



	/*
	| this function for if flight is booked
	| id stand for the table id 
	| index for the result column array index like flight index 
	*/
	public function book($id, $index)
	{
		$flight = QpxFlightModel::find($id);
		
		$return = false;

		if (!is_null($flight)) {
			// this is result in json which is got from calling qpx flight api 
			$flightDetail = $flight->result;
			// putting index in selected_index column in db 
			$flight->selected_index  =  $index;
			// saving data here
			$flight->save();

			$tripOption = $flightDetail->trips->tripOption[$index];

			// finding Start Date here
			$startDate = isset($tripOption->slice[0]->segment[0]->leg[0]->departureTime)
								 ? getDefaultDateTime($tripOption->slice[0]->segment[0]->leg[0]->departureTime)
								 : '0000-00-00 00:00:00';

			// finding sliceCount, segmentCount and legCount here
			$sliceCount = count($tripOption->slice)-1;
			$segmentCount = count($tripOption->slice[$sliceCount]->segment)-1;
			$legCount = count($tripOption
									->slice[$sliceCount]
										->segment[$segmentCount]
											->leg)-1;

			// finding end Date here
			$endDate = getDefaultDateTime($tripOption
								->slice[$sliceCount]
									->segment[$segmentCount]
										->leg[$legCount]
											->arrivalTime);

			// this array have to be return,
			$return = (object)[
					"startDate" => $startDate,
					"endDate" => $endDate,
					"vendor" => 'qpx',
					"tripOption" => $tripOption
				];
			
		}
		return $return;
	}


	public function saveKey()
	{
		$qpxLimit = new QpxLimitModel;
		$qpxLimit->key = $this->key;
		$qpxLimit->save();
	}


	/*
	| This function is for posting http posting request
	*/
  public function httpPost($url, $array){
		
		$postData = json_encode($array);

		$curlConnection = curl_init();

		curl_setopt($curlConnection, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($curlConnection, CURLOPT_URL, $url);
		curl_setopt($curlConnection, CURLOPT_POST, true);
		curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, false);

		$results = curl_exec($curlConnection);
		
		curl_close($curlConnection);

		return $results;

	}

	public function __construct()
	{
		$this->setQpxKey();
	}

	public function setQpxKey()
	{
		$qpxKeys = [
				env('QPX_KEY'), 
				env('QPX_KEY1'),
				env('QPX_KEY2'),
				env('QPX_KEY3'),
				env('QPX_KEY4')
			];
		foreach ($qpxKeys as $qpxKeys) {
			$todayCalled = QpxLimitModel::call()->todayCalled($qpxKeys);
			if ($todayCalled->count() < 50) {
				$this->key = $qpxKeys;
				break;
			}
		}
	}
}
