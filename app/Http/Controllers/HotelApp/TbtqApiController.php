<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Curl;

ini_set('max_execution_time', 3600);


class TbtqApiController extends Controller
{

	private function postData($url, $array){
		$response = Curl::to($url)
		->withData($array)
		->asJson()
		->post();
		return $response;
	}

	public function postTBTQ($url, $data = '', $decode = true){

		$field = json_encode($data);
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length:'.strlen($field)));
		
		//execute post
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,60);
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		//echo "function";
		// saveInFile($result, 'Api/Post_Data','json');
		$decodeResult = json_decode($result, true);

		if ($decodeResult == '') {
			$decodeResult = $result;
		}

		return  $decode == true ? $decodeResult : $result;
	}


	public function authenticate(){
		
		$auth_url = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/Authenticate';
		$auth_array = [
			"ClientId"=> "ApiIntegration",
			"UserName"=> "finch",
			"Password"=> "finch@123",
			"EndUserIp" => $_SERVER['REMOTE_ADDR']
		];

		$response = $this->postTBTQ($auth_url, $auth_array);

		return $response != null ? $response : '';
	}   

	public function countyList(){
		
		$auth = $this->authenticate();
		// pre_echo($auth->TokenId);

		$url = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/CountryList';

		$request = [
			"TokenId" => "051aa29d-f9a4-4d2f-8b52-9dc40a096394",
			"ClientId" => "ApiIntegration",
			"EndUserIp" => $_SERVER['REMOTE_ADDR'],
		];

		$response = $this->postTBTQ($url, $request); 

		if($response != null){
			return 'serverError';
		}
		else{
			return 'serverError';
		}
	}

	public function destinationList(){
		$url = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/DestinationCityList';

		$countryCodes = ["AF","AL","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AW","AU","AT","AZ","BS","BH","BD","BB","BY","BE","BZ","BJ","BM","BT","BO","BA","BW","BV","BR","IO","VG","BN","BG","BF","BI","KH","CM","CA","CB","CV","KY","CF","TD","CL","CN","CX","CC","CO","KM","CG","CD","CK","CR","HR","CU","CY","CZ","DK","DJ","DO","DM","TP","EC","EG","SV","GQ","ER","EE","ET","EU","FK","FO","FJ","FI","FR","GF","PF","TF","GA","GM","GE","DE","GH","GI","GR","GL","GD","GP","GU","GT","GN","GW","GY","HT","HM","HN","HK","HU","IS","IN","ID","IR","IQ","IE","IL","IT","CI","JM","JP","JO","KZ","KE","KI","KP","KW","KG","LA","LV","LB","LS","LR","LY","LI","LT","QL","LU","MO","MK","MG","MW","MY","MV","ML","MT","MH","MQ","MR","MU","YT","MX","MB","FM","MD","MC","MN","MS","MA","MZ","MM","NA","NR","NP","NL","AN","NC","NZ","NI","NE","NG","NU","NF","MP","NO","OM","PK","PW","PS","PA","PG","PY","PE","PH","PL","PT","PR","QA","RE","RO","RW","RU","LC","WS","SM","ST","SA","SN","SC","SL","SG","SK","SI","SB","SO","ZA","GS","KR","SU","ES","LK","SH","KN","PM","VC","SD","SR","SJ","SZ","SE","CH","SY","TW","TJ","TZ","TH","TG","TK","TO","TT","TN","TC","TR","TM","TV","UM","UG","UA","AE","GB","UY","US","UZ","VU","VA","VE","VN","VI","WF","EH","YE","YU","ZM","ZW"];

		// $responseJson = '';

		// foreach ($countryCodes as $countryCode) {
		// 	$request = [
		// 		"TokenId" => "051aa29d-f9a4-4d2f-8b52-9dc40a096394",
		// 		"ClientId" => "ApiIntegration",
		// 		"EndUserIp" => $_SERVER['REMOTE_ADDR'],
		// 		"CountryCode" => $countryCode
		// 	];

		// 	$response = $this->postJsonTBTQ($url, $request); 
		// 	$responseJson .= '{"'.$countryCode.'":'.$response.'}, ';
		// }

		// $myfile = fopen("destinationList.txt", "w") or die("Unable to open file!");
		// fwrite($myfile, '['.$responseJson.']');
		// fclose($myfile);
	}

	public function getHotelResult($request){

		// pre_echo($request);

		$url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelResult/';

		$auth = $this->authenticate();

		if ($auth != null) {

			$NoOfRooms = count($request['RoomGuests']);
			$RoomGuests = $this->roomGuests($request['RoomGuests']);
			// pre_echo($RoomGuests);
			// dd();

			$hotelRequest = [
				"TokenId" => $auth['TokenId'], // Got after Authenticate
				"EndUserIp" => $_SERVER['REMOTE_ADDR'],
				"CheckInDate" => date_formatter($request['Dates']['CheckInDate'],'Y-m-d', 'd/m/Y'), // DD/MM/YYYY
				"NoOfNights" => date_differences($request['Dates']['CheckOutDate'],$request['Dates']['CheckInDate']), // 3
				"CountryCode" => $request['Destination']['tbtq_countrycode'], // SG
				"CityId" => $request['Destination']['tbtq_destinationcode'], // 14343
				"ResultCount" => 1000, // 1000
				"PreferredCurrency" => $request['PreferredCurrency'], // INR
				"GuestNationality" => "IN", // IN
				"NoOfRooms" => $NoOfRooms, // = count(RoomGuests);
				"RoomGuests" => $RoomGuests,
				"PreferredHotel" => "", // name of hotel
				"MaxRating" => 5, // like 5
				"MinRating" => 1, // like 3
				"ReviewScore" => 0, // like 4
				"IsNearBySearchAllowed" => 0, // boolen 
				// "SortBy" => "",// like "Sort by Price, Star Rating"
				// "Order" => "",// int like "Ascending or Descending Order"
			];

			$response =  [];
			$response =  $this->postTBTQ($url, $hotelRequest);
			// dd_pre_echo($response);
			if (isset($response['HotelSearchResult'])) {
				$response['HotelSearchResult']['TokenId'] = $auth['TokenId'];
				$response['HotelSearchResult']['Location'] = $request['Destination'];
			}
			else{
				$response =  [];
			}
			// $response['GlobalHotelResults'] = $this->globalHotelResult($response); // not calling this method here because it called in packageBuildercontroller
			// saveInfile(json_encode($response), 'hotelResult', 'json');
			return $response;
		}
	}

	public function getHotelRoom($request){
		
		$request_initialize = [
			"HotelCode" => [],
			"HotelName" => [],
			"CheckInDate" => [],
			"CheckOutDate" => [],
			"StarRating" => [],
			"Latitude" => [],
			"Longitude" => [],
			"Address" => [],
			"GuestNationality" => [],
			"PreferredCurrency" => [],
			"EndUserIp" => [],
			"HotelPolicy" => [],
			"Location" => [],
			"Attractions" => [],
			"Facilities" => [],
			"Images" => [],
			"HotelContactNo" => [],
			"FaxNumber" => [],
			"Email" => [],
			"RoomFacilities" => [],
			"Services" => [],
			"Description" => [],
		];
		
		// initializing some key which is not exist
		$request = array_merge($request_initialize,$request);

		$hotelRoom_url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelRoom/';
		$hotelDetail_url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelInfo/';

		/*
		|---------------------------------------------------------
		| Tbtq hotel room result's request will be like that
		|---------------------------------------------------------
		*/

		$roomRequest = [
			"ResultIndex" => $request['ResultIndex'],
			"HotelCode" => $request['HotelCode'],
			"EndUserIp" => $request['EndUserIp'],
			"TokenId" => $request['TokenId'],
			"TraceId" => $request['TraceId'],
		];

		$responseRoom =  [];
		$responseRoom =  $this->postTBTQ($hotelRoom_url, $roomRequest);
		$responseInfo =  $this->postTBTQ($hotelDetail_url, $roomRequest);
		$responseInfo_temp = isset($responseInfo['HotelInfoResult']['HotelDetails']) ? $responseInfo['HotelInfoResult']['HotelDetails'] : [];
		$responseRoom['GetHotelRoomResult']['Request'] = array_merge($request, $responseInfo_temp);

		// saveInfile(json_encode($responseRoom),'Api/RoomResultAndInfoData');

		return $responseRoom;
	}


	/*
	|--------------------------------------------------------------------------
	| Checking or Fixing request field 
	|--------------------------------------------------------------------------
	*/

	public function roomGuests($array){

		if (bool_array($array)) {
			$TRUE = FALSE;

			foreach ($array as $key => &$value) {
				
				if (isset($value['NoOfAdults']) && isset($value['ChildAge'])) {
					$value['NoOfChild'] = count($value['ChildAge']);
					$TRUE = TRUE;
				}
				else{
					return FALSE;
					break;
				}
			}
			
			return $TRUE ? $array : FALSE;
		}
		else{
			return FALSE;
		}
	}








	/*
	|--------------------------------------------------------------------------
	| Make Global Hotel Result Array
	|--------------------------------------------------------------------------
	|	["HotelCode", "HotelName", "StarRating", "HotelDescription", "HotelPicture", 
	|	"Price", "HotelAddress", "Latitude", "Longitude", "TripAdvisor"]
	|
	*/


	public function globalHotelResult($array,$index){
		if (isset($array['HotelSearchResult']['ResponseStatus']) && $array['HotelSearchResult']['ResponseStatus'] == 1) {

			$HotelResults = [];
			if (bool_array($array['HotelSearchResult']['HotelResults'])) {
				foreach ($array['HotelSearchResult']['HotelResults'] as $hotelResult_Key => $hotelResult) {
					$HotelResults[] = [
						"DbApiAccessKey" => ["tbtq->".$index."->HotelSearchResult->HotelResults->".$hotelResult_Key],
						"ApiRequests" => [
							[
								"tbtq" => [
									"ResultIndex" => $hotelResult['ResultIndex'],
									"HotelCode" => $hotelResult['HotelCode'],
									"HotelName" => $hotelResult['HotelName'],
									"hotelPicture" => $hotelResult['HotelPicture'],
									"HotelAddress" => $hotelResult['HotelAddress'],
									"HotelDescription" => addslashes($hotelResult['HotelDescription']),
									"StarRating" => $hotelResult['StarRating'],
									"Latitude" => $hotelResult['Latitude'],
									"Longitude" => $hotelResult['Longitude'],
									"NoOfRooms" => $array['HotelSearchResult']['NoOfRooms'],
									"RoomGuests" => $array['HotelSearchResult']['RoomGuests'],
									"CityId" => $array['HotelSearchResult']['CityId'],
									"CheckInDate" => $array['HotelSearchResult']['CheckInDate'],
									"CheckOutDate" => $array['HotelSearchResult']['CheckOutDate'],
									"GuestNationality" => "IN",
									"PreferredCurrency" => $array['HotelSearchResult']['PreferredCurrency'],
									"EndUserIp" => $_SERVER['REMOTE_ADDR'],
									"TokenId" => $array['HotelSearchResult']['TokenId'],
									"TraceId" => $array['HotelSearchResult']['TraceId'],
									"Location" => $array['HotelSearchResult']['Location'],
								]
							]
						], // this contain that index which is in the hotelresult column database
						"HotelCode" => $hotelResult['HotelCode'],
						"HotelName" => $hotelResult['HotelName'],
						"StarRating" => $hotelResult['StarRating'],
						"HotelDescription" => $hotelResult['HotelDescription'],
						"HotelPicture" => $hotelResult['HotelPicture'],
						"Price" => $hotelResult['Price']['OfferedPriceRoundedOff'],
						"HotelAddress" => $hotelResult['HotelAddress'],
						"Latitude" => $hotelResult['Latitude'],
						"Longitude" => $hotelResult['Longitude'],
						"TripAdvisor" => isset($hotelResult['TripAdvisor']) ? $hotelResult['TripAdvisor'] : (object)[],
					];
				}
			}

			return $HotelResults;

		}
		else{
			return FALSE;
		}
	}

	public function globalHotelRoom($array,$index){
		
		$HotelRoomsDetails = [];
		$request = $array['GetHotelRoomResult']['Request'];

		if (isset($array['GetHotelRoomResult']['ResponseStatus']) && $array['GetHotelRoomResult']['ResponseStatus'] == 1) {

			if (bool_array($array['GetHotelRoomResult']['HotelRoomsDetails'])) {
				foreach ($array['GetHotelRoomResult']['HotelRoomsDetails'] as $hotelRoom_Key => $hotelRoom) {
					$Attractions = [];

					if (bool_array($request['Attractions'])) {
						foreach ($request['Attractions'] as $Attraction) {
							$Attractions[] = ifset($Attraction['Value']);
						}
					}

					$HotelRoomsDetails[] = [
						// request array data will be here
						"HotelCode" => $request['HotelCode'],
						"HotelName" => $request['HotelName'],
						"CheckInDate" => $request['CheckInDate'],
						"CheckOutDate" => $request['CheckOutDate'],
						"StarRating" => $request['StarRating'],
						"HotelPicture" => $request['hotelPicture'],
						"Latitude" => $request['Latitude'],
						"Longitude" => $request['Longitude'],
						"Address" => $request['Address'],
						"Description" => $request['Description'], // may be html
						"GuestNationality" => $request['GuestNationality'],
						"PreferredCurrency" => $request['PreferredCurrency'],
						"HotelPolicy" => $request['HotelPolicy'],
						"Location" => $request['Location'],
						"Attractions" => $Attractions,
						"Facilities" => $request['HotelFacilities'],
						"Images" => $request['Images'],
						"ContactNo" => $request['HotelContactNo'],
						"FaxNumber" => $request['FaxNumber'],
						"Email" => $request['Email'],
						"RoomFacilities" => $request['RoomFacilities'],
						"Services" => $request['Services'],
						"EndUserIp" => $request['EndUserIp'],
						// end here request array data will be here

						"RoomTypeCode" => $hotelRoom['RoomTypeCode'],
						"RoomTypeName" => $hotelRoom['RoomTypeName'],
						"Amenities" => $hotelRoom['Amenities'],
						"CancellationPolicy" => $hotelRoom['CancellationPolicy'],
						"Inclusions" => $hotelRoom['Inclusions'],
						"Price" => $hotelRoom['Price']['OfferedPriceRoundedOff'],
						"PriceBreakUp" => $hotelRoom['Price'],
						"ApiRequests" => [
							[
								"tbtq" => [

									"Block" => [
										"ResultIndex" => $request['ResultIndex'],
										"HotelCode" => $request['HotelCode'],
										"HotelName" => $request['HotelName'],
										"GuestNationality" => $request['GuestNationality'],
										"NoOfRooms" => $request['NoOfRooms'],
										"ClientReferenceNo" => "0",
										"IsVoucherBooking" => "true",
										"HotelRoomsDetails" => [
											[
												"RoomIndex" => $hotelRoom['RoomIndex'],
												"RoomTypeCode" => $hotelRoom['RoomTypeCode'],
												"RoomTypeName" => $hotelRoom['RoomTypeName'],
												"RatePlanCode" => $hotelRoom['RatePlanCode'],
												"BedTypeCode" => null,
												"SmokingPreference" => 0,
												"Supplements" => null,
												"Price" => $hotelRoom['Price']
													/*[
														"CurrencyCode" => "INR",
														"RoomPrice" => "4620.0",
														"Tax" => "0.0",
														"ExtraGuestCharge" => "0.0",
														"ChildCharge" => "0.0",
														"OtherCharges" => "0.0",
														"Discount" => "0.0",
														"PublishedPrice" => "4620.0",
														"PublishedPriceRoundedOff" => "4620",
														"OfferedPrice" => "4620.0",
														"OfferedPriceRoundedOff" => "4620",
														"AgentCommission" => "0.0",
														"AgentMarkUp" => "0.0",
														"ServiceTax" => "92.4",
														"TDS" => "0.0"
													]*/
											]
										],
										"EndUserIp" => $_SERVER['REMOTE_ADDR'],
										"TokenId" => $request['TokenId'],
										"TraceId" => $request['TraceId'],
									],

									"Book" => $book = [
										"ResultIndex" => $request['ResultIndex'],
										"HotelCode" => $request['HotelCode'],
										"HotelName" => $request['HotelName'],
										"GuestNationality" => $request['GuestNationality'],
										"NoOfRooms" => $request['NoOfRooms'],
										"ClientReferenceNo" => "0",
										"IsVoucherBooking" => "true",

										"HotelRoomsDetails" => [
											[
												"RoomIndex" => $hotelRoom['RoomIndex'],
												"RoomTypeCode" => $hotelRoom['RoomTypeCode'],
												"RoomTypeName" => $hotelRoom['RoomTypeName'],
												"RatePlanCode" => $hotelRoom['RatePlanCode'],
												"BedTypeCode" => null,
												"SmokingPreference" => 0,
												"Supplements" => null,
												"Price" => $hotelRoom['Price'],

												"HotelPassenger" => [
													[
														"Title" => "mr",
														"FirstName" => "GTA",
														"Middlename" => null,
														"LastName" => "Service",
														"Phoneno" => null,
														"Email" => null,
														"PaxType" => 1,
														"LeadPassenger" => true,
														"Age" => 0,
														"PassportNo" => null,
														"PassportIssueDate" => null,
														"PassportExpDate" => null
													]
												]
											]
										],
										"EndUserIp" => $_SERVER['REMOTE_ADDR'],
										"TokenId" => $request['TokenId'],
										"TraceId" => $request['TraceId'],
									]
								]
							]
						], // this contain that index which is in the hotelresult column database

					];
				}
			}

			return $HotelRoomsDetails;

		}
		else{
			return FALSE;
		}
	}

}
