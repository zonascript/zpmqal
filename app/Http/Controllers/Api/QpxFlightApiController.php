<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===========================Model===========================
use App\Models\Api\QpxLimitModel;
use App\Models\Api\QpxFlightModel;

class QpxFlightApiController extends Controller
{
	public $solutions = 500;
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
							"date" => $packageFlight->route->start_date,
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
			// putting index in selected_index column in db 
			$flight->selected_index  =  $index;
			// saving data here
			$flight->save();

			// this array have to be return,
			$return = (object)[
					"startDateTime" => $flight->departureDateTime,
					"endDateTime" => $flight->arrivalDateTime,
					"vendor" => 'qpx',
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


	public function httpPost($url, $array)
	{
		$postData = json_encode($array);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://content.googleapis.com/qpxExpress/v1/trips/search?key=".$this->key."&alt=json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/json",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return $response;
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


	/*
	| This function is for posting http posting request
	*/
  public function httpPostOld($url, $array){
		
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
		// $this->key = env('QPX_KEY');
		$this->setQpxKey();
	}


}
