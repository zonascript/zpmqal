<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===================================Models===================================
use App\Models\Api\TbtqHotelModel;
use App\Models\Api\TbtqHotelRoomModel;
use App\Models\Api\TbtqHotelDetailModel;


class TbtqHotelApiController extends Controller
{
	public static function call()
	{
		return new TbtqHotelApiController;
	}


	/*
	| this function for getting token from tbtq
	*/
	public function authenticate(){
		
		$auth_url = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/Authenticate';
		$auth_array = [
				"ClientId"=> "ApiIntegration",
				"UserName"=> "finch",
				"Password"=> "finch@123",
				"EndUserIp" => $_SERVER['REMOTE_ADDR']
			];

		$response = $this->httpPost($auth_url, $auth_array);

		return json_decode($response);
	}


	public function hotel($request)
	{
		$auth = $this->authenticate();

		$result = null;

		if (isset($auth->TokenId)) {

			$RoomGuests = $this->roomGuests($request->RoomGuests);
			$NoOfRooms = count($RoomGuests);

			$params = [
					"TokenId" => $auth->TokenId, // Got after Authenticate
					"EndUserIp" => $_SERVER['REMOTE_ADDR'],
					"CheckInDate" => date_formatter($request->Dates->CheckInDate, null, 'd/m/Y'), // DD/MM/YYYY
					"NoOfNights" => date_differences($request->Dates->CheckOutDate, $request->Dates->CheckInDate), // 3
					"CountryCode" => $request->Destination->tbtq_countrycode, // SG
					"CityId" => $request->Destination->tbtq_destinationcode, // 14343
					"ResultCount" => 1000, // 1000
					"PreferredCurrency" => $request->PreferredCurrency, // INR
					"GuestNationality" => "IN", // IN
					"NoOfRooms" => $NoOfRooms, // = count(RoomGuests);
					"RoomGuests" => $RoomGuests,
					"PreferredHotel" => "", // name of hotel
					"MaxRating" => 5, // like 5
					"MinRating" => 3, // like 3
					"ReviewScore" => 0, // like 4
					"IsNearBySearchAllowed" => 0, // boolen 
					// "SortBy" => "",// like "Sort by Price, Star Rating"
					// "Order" => "",// int like "Ascending or Descending Order"
				];

			$result = $this->postHotel($params);
		}

		return $result;
	}



	/*
	| this function is making request array and getting data
	*/
	public function hotelRoom($id, $index)
	{
		$tbtqHotelModel = TbtqHotelModel::find($id);
		$hotels = $tbtqHotelModel->result;
		$request = $tbtqHotelModel->request; 
		$result = (object)['rooms' => null, 'detail' => null ];

		if (!is_null($hotels) && !is_null($request)) {

			$params = [
					"ResultIndex" =>$hotels->HotelSearchResult->HotelResults[$index]->ResultIndex,
					"HotelCode" => $hotels->HotelSearchResult->HotelResults[$index]->HotelCode,
					"EndUserIp" =>$request->EndUserIp,
					"TokenId" =>$request->TokenId,
					"TraceId" =>$hotels->HotelSearchResult->TraceId
				];
			$result->rooms = $this->postHotelRoom($params);	
			$result->detail = $this->postHotelDetail($params);	
			
			// updating some colums here
			$tbtqHotelModel->temp_selected_index = $index;
			$tbtqHotelModel->tbtq_hotel_room_id = $result->rooms->db->id;
			$tbtqHotelModel->tbtq_hotel_detail_id = $result->detail->db->id;
			$tbtqHotelModel->save();
		}
		return $result;
	}




	/*
	| this function for if flight is booked
	| id stand for the table id 
	| index for the result column array index like flight index 
	*/
	public function book($id, $index)
	{
		$hotel = TbtqHotelModel::with('tbtqRooms')->find($id);
		$hotel->selected_index = $hotel->temp_selected_index; 
		$hotel->tbtqRooms->selected_index = $index;
		$hotel->tbtqRooms->save();
		$hotel->save();
		
		return $hotel;
	}


	

	/*
	| this function for pulling data from tbtq using method post 
	*/
	public function postHotel($params)
	{
		$url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelResult/';

		$json = null;
		$result = null;
		
		for ($i=0; $i <5; $i++) { 
			$json = $this->httpPost($url, $params);
			$result = json_decode($json);
			if (isset($result->HotelSearchResult->ResponseStatus)) {
				break;
			}
		}

		$tbtqHotelModel = new TbtqHotelModel;
		$tbtqHotelModel->request = $params;
		$tbtqHotelModel->result = $json;
		$tbtqHotelModel->save();

		if (!is_object($result)) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $tbtqHotelModel->id, 
				// "table" => "tbtq_hotels"
			];
		return $result;
	}


	/*
	| this function is for pulling rooms data from tbtq api 
	| using post method 
	*/
	public function postHotelRoom($params)
	{
		$url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelRoom/';

		$result =  $this->httpPost($url, $params);

		$tbtqHotelRoomModel = new TbtqHotelRoomModel;
		$tbtqHotelRoomModel->request = $params;
		$tbtqHotelRoomModel->result = $result;
		$tbtqHotelRoomModel->save();

		$result = json_decode($result);
		if (!$result) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $tbtqHotelRoomModel->id, 
				// "table" => "tbtq_hotel_rooms"	
			];
		return $result;

	}



	/*
	| this function is for pulling rooms data from tbtq api 
	| using post method 
	*/
	public function postHotelDetail($params)
	{
		/* 
		| first finding from db that is alread had or not 
		| if not then it will return null
		*/
		$result = TbtqHotelDetailModel::call()->findByHotelCode($params['HotelCode']);

		if (is_null($result)) {

			$url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelInfo/';

			$json =  $this->httpPost($url, $params);
			
			$status = 'inactive';

			$result = json_decode($json);
			
			if (is_null($result)) {
				$result = (object)[];
			}

			if (ifset($result->HotelInfoResult->ResponseStatus) == 1) {
				$status = 'active';
			}

			$tbtqHotelDetailModel = new TbtqHotelDetailModel;
			$tbtqHotelDetailModel->hotel_code = $params['HotelCode'];
			$tbtqHotelDetailModel->request = $params;
			$tbtqHotelDetailModel->result = $json;
			$tbtqHotelDetailModel->status = $status;
			$tbtqHotelDetailModel->save();

			

			// ====================pushing db detail in array====================
			$result->db = (object)[
					"id" => $tbtqHotelDetailModel->id, 
					// "table" => "tbtq_hotel_rooms"
				];
		}

		return $result;
	}



	/*
	|--------------------------------------------------------------------------
	| Checking or Fixing request field 
	|--------------------------------------------------------------------------
	*/
	public function roomGuests($array){
		$roomGuests = [];

		foreach ($array as $value) {
			$NoOfAdults = isset($value->no_of_adult) ? $value->no_of_adult : 0;

			$roomGuest = [
					'NoOfAdults' => $NoOfAdults, 
					'NoOfChild' => 0,
					'ChildAge' => []
				];

			if (isset($value->child_age) && !empty(isset($value->child_age))) {
				
				$roomGuest['NoOfChild'] = count($value->child_age);

				foreach ($value->child_age as $childAge) {
					$roomGuest['ChildAge'][] = $childAge->age;
				}
			}
			
			$roomGuests[] = $roomGuest;

		}
		
		return $roomGuests;
	}



	/*
	| This function is for posting http posting request
	*/
	public function httpPost($url, $data = ''){

		$field = json_encode($data);
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json', 
				'Content-Length:'.strlen($field)
			]);
		
		//execute post
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,60);

		$result = curl_exec($ch);
		//close connection
		curl_close($ch);

		return $result;
	}

}
