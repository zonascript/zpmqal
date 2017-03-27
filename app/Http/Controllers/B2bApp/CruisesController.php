<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ================================B2bApp Controller===============================
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\RouteController;

// =================================Api Controller=================================
use App\Http\Controllers\Api\CruiseController;
use App\Http\Controllers\Api\DestinationController;

// =====================================Model======================================
use App\Models\B2bApp\PackageCruiseModel;

use Auth;


class CruisesController extends Controller
{

	public static function call(){
		return new cruisesController;
	}

	public function model(){
		return new PackageCruiseModel;		
	}

	public function find($id){
		return PackageCruiseModel::find($id);
	}

	public function findByRouteId($routeId, $colunm = '*')
	{
		return PackageCruiseModel::select($colunm)->where(['route_id' => $routeId])->first();
	}

	public function book($id){
		PackageCruiseModel::call()->book($id);
	}
	
	public function createNew($object)
	{
		$packageCruise = $this->isExist($object->route_id);
		
		if (is_null($packageCruise)) {
			$packageCruise = new PackageCruiseModel;
		}

		$packageCruise->route_id = $object->route_id;
		$packageCruise->status = "active";
		$packageCruise->save();

		return $packageCruise->id;
	}


	public function createNewByRoute($routeDbId)
	{

		$route = RouteController::call()->find($routeDbId);
		$package = PackageController::call()->find($route->package_id);

		$events = json_decode($route->events);

		$destination = $route->destination;
		$destination = explode(' | ', $route->destination);
		$destination = 	ifset($destination[1], $destination[0]);

		// dd_pre_echo($destination);
		$destinationArray = DestinationController::call()->search($destination);
		// echo $destinationArray;
		// dd_pre_echo($destinationArray);
		$city_id = isset($destinationArray->id) ? $destinationArray->id : $destination;

		$newcruiseDetail = (object)[
				'package_id' => $route->package_id, 
				'route_id' => $routeDbId, 
				'city_id' => $city_id, 
				'check_in_date' => $events->cruise->startDate, 
				'nights' => $route->nights, 
				'room_guests' => $package->guests_detail, 
				'location' => json_encode($destinationArray)
			];

		return $this->createNew($newcruiseDetail);

	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($routeDbId)
	{
		$packageCruise = PackageCruiseModel::select()
										->where([
													"route_id" => $routeDbId,
												])
											->first();

			return $packageCruise;
	}



	/*
	| this function is to get view on the browser using get request
	*/
	public function getCruisesByPackageId($packageDbId)
	{
		$package = PackageController::call()->model()->usersFind($packageDbId);
		// dd($package->cruiseRoutes[0]->cruise);
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		// dd($package->hotelRoutes[0]->location_hotel);
		return view('b2b.protected.dashboard.pages.cruises.index', $blade);
	}

	public function findpackageCruise($packageDbId, $packageCruiseId, $checkOnly = false)
	{
		$auth = Auth::user();
		$packageCruise = PackageCruiseModel::select()
									->where([
											"id" => $packageCruiseId,
											"package_id" => $packageDbId,
											"user_id" => $auth->id,
										])
									->get();

		if ($packageCruise->count() >= 1) {
			return $checkOnly ? true : $packageCruise[0];
		}
		else{
			return $packageCruise;
		}

	}

	public function enquiryExist($packageDbId, $packageCruiseId){
		$result = $this->findpackageCruise($packageDbId, $packageCruiseId, true);
		return $result ? true : false;
	}

	public function allEnquiry($id, $packageDbId, $colunm = '*'){
		$auth = Auth::user();

		if (PackageController::call()->validPackage($id, $packageDbId)) {
			$packageCruise = PackageCruiseModel::select($colunm)
										->where([
												"package_id" => $packageDbId,
												"user_id" => $auth->id,
											])
										->get();

			return $packageCruise->count() >= 1 ? $packageCruise : false;
		}
		else{
			return false;
		}
	}


	public function nextCart($id, $packageDbId, $packageCruiseId){
		// $packageCruiseId is the current id
		$allEnquiry = $this->allEnquiry($id, $packageDbId, ["id","package_id"]);
		
		$i = 0;

		if ($allEnquiry && $allEnquiry->count() > 1 ) {
			foreach ($allEnquiry as $key => $value) {
				if ($i == 1) {
					return $value->id;
					break;
				};

				$i = $value->id == $packageCruiseId ? 1 : 0;
			}
		}else{
			return false;
		}
	}


	public function getCruises($id, $packageDbId, $packageCruiseId)
	{

		$getCurrentCart = $this->findpackageCruise($packageDbId, $packageCruiseId);

		if (ClientController::call()->validClient($id) && $getCurrentCart->count() > 0) {
			
			// getting menus data like cruises, flight, cabs 
			$menus = MenusController::call()->getPackageMenus($packageDbId);
			// dd_pre_echo($menus);

			// fatching destination from db here
			$destination = DestinationController::call()->find($getCurrentCart->city_id);
			// dd($destination);
			$roomGuests = getPax(json_decode($getCurrentCart->room_guests));

			// this is global request array
			$requestArray = [
				"checkInDate" => $getCurrentCart->check_in_date,
				"city_id" => $destination->fgf_destinationcode,
				"nights" => $getCurrentCart->nights,
				"adultCount" => $roomGuests->NoOfAdults,
				"childAge" => $roomGuests->ChildAge, 
				"minRating" => 1,
				"maxRating" => 5,
				"PreferredCurrency" => "INR",
			];

			$cruiseResults = CruiseController::call()->cruise($requestArray);

			// inserting cruise data in db
			$getCurrentCart->temp_fgf_cruise_result = json_encode($cruiseResults);

			// saving cruise data in db here
			$getCurrentCart->save();

			// ----------------- Geting all cruise form database ---------------//
			$client = ClientController::call()->info($id);

			// blade data here
			$bladeData = [
				"client" => $client,
				"cartData" => nested_jsonDecode(rejson_decode($getCurrentCart)),
				"urlVariable" => (object)[
					"id" => $id,
					"packageId" => 'FGF'.str_pad($packageDbId, 5, '0', STR_PAD_LEFT),
					"packageDbId" => $packageDbId, 
					"packageCrusiesId" => $packageCruiseId,
				],
				"menus" => $menus,
				"cruiseResults" => $cruiseResults
			];

			// dd_pre_echo($bladeData);
			
			return view('b2b.protected.dashboard.pages.cruise.index', $bladeData);

		}
		else{
			return view('errors.404');
		}
	}

	/* 
	|$id : this is index of clients table,
	|$packageId : this is Package Id for client,
	|$upadateId : that id which indicate how many working done on the package
	|$cartId : this is the index of package_cruise
	*/

	public function getCruiseCabin($id, $packageDbId, $packageCruiseId, Request $request)
	{

		$getCurrentCart = $this->findpackageCruise($packageDbId, $packageCruiseId);

		if (ClientController::call()->validClient($id) && $getCurrentCart->count() > 0) {
			// dd_pre_echo($getCurrentCart);
			$cruiseResults = json_decode($getCurrentCart->temp_fgf_cruise_result);

			$roomGuests = getPax(json_decode($getCurrentCart->room_guests));

			$selectedCruise = $cruiseResults[$request->Index];

			$params = [
				"resultIndex" => $selectedCruise->resultIndex,
				"checkInDate" => $getCurrentCart->check_in_date,
				"nights" => $getCurrentCart->nights,
				"adultCount" => $roomGuests->NoOfAdults,
				"childAge" => $roomGuests->ChildAge, 
				"minRating" => 1,
				"maxRating" => 5
			];

			$cruiseCabinResult = CruiseController::call()->cruiseCabin($params);

			$selectedCruise->cabin = $cruiseCabinResult;

			$getCurrentCart->temp_fgf_cabin_result = json_encode($selectedCruise);
			$getCurrentCart->save();

			$bladeData = [
					"requestIndex" => $request->Index, 
					"cruiseCabinResult" => $cruiseCabinResult,
				];

			return view('b2b.protected.dashboard.pages.cruise.partials.content_cruise_cabin', $bladeData);

		}
		else{
			return false;
		}
	}

	public function postBookCrusieCabin($id, $packageDbId, $packageCruiseId, Request $request)
	{
		$getCurrentCart = $this->findpackageCruise($packageDbId, $packageCruiseId);
		$auth = Auth::user();

		if (ClientController::call()->validClient($id) && $getCurrentCart->count() > 0) {

			$cruiseCabinResult = json_decode($getCurrentCart->temp_fgf_cabin_result);

			if (isset($cruiseCabinResult->cabin[$request->Index]) ) {

				$selectedCabin = $cruiseCabinResult->cabin[$request->Index];

				$cruiseCabinResult->cabin = $selectedCabin;
	      $getCurrentCart->selected_cabin = json_encode($cruiseCabinResult);
	      								

	      /*=======this line used to update internal db column wiht temp column=======*/
	      $this->book($packageCruiseId);

	      $routeDbId = $getCurrentCart->route_id;

				$getCurrentCart->user_id = $auth->id;
				$getCurrentCart->status = 'occupied';
				$getCurrentCart->save();

				$route = RouteController::call()->find($routeDbId);
				$events = json_decode($route->events);
				$events->cruise->status = 'done';
				
				$route->status = 'complete';

				$route->events = json_encode($events);
				$route->save();
			
				$returnArray = [ 
					"status" => 200,
					"packageUrl" => newRedirectUrl(urlPackageAll($id, $packageDbId)),
					"nextUrl" => newRedirectUrl(urlPackageEvent($routeDbId)),
				];
				
				return json_encode($returnArray);
			}
			else{
				return view('errors.404');
			}
		}
		else{
			return view('errors.404');
		}
	}


	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postFgfCruiseResult($id)
	{
		// return file_get_contents(public_path('faker\fgfcruise.json'));

		$packageCruise = PackageCruiseModel::find($id);
		$adultCount = isset($packageCruise->route->package->pax_detail->adult)
								? $packageCruise->route->package->pax_detail->adult
								: 0;

		$params = [
				"checkInDate" => $packageCruise->route->start_datetime->date,
				"city_id" => $packageCruise->route->destination_detail->fgf_destinationcode,
				"nights" => $packageCruise->route->nights,
				"adultCount" => $adultCount,
				"childAge" => [], 
				"minRating" => 1,
				"maxRating" => 5,
				"PreferredCurrency" => "INR",
			];

		if (!is_null($params)) {
			$result = CruiseController::call()->cruise($params);
		}

		if (isset($result->db->id)) {
			$packageCruise->fgf_temp_cruise_id = $result->db->id;
			$packageCruise->save();
		}
		return json_encode($result);
	}


	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postFgfCruiseCabin($id)
	{
		// return file_get_contents(public_path('faker\fgfcruise.json'));
		$index = 0;
		$packageCruise = PackageCruiseModel::find($id);

		$resultIndex = $packageCruise->fgfTempCruise
									->result->cruises[$index]->resultIndex;

		$adultCount = isset($packageCruise->route->package->pax_detail->adult)
								? $packageCruise->route->package->pax_detail->adult
								: 0;

		$params = [
				"resultIndex" => $resultIndex,
				"checkInDate" => $packageCruise->route->start_datetime->date,
				"nights" => $packageCruise->route->nights,
				"adultCount" => $adultCount,
				"childAge" => [], 
				"minRating" => 1,
				"maxRating" => 5,
			];

		$result = CruiseController::call()->cruiseCabin($params);

		if (isset($result->db->id)) {
			$packageCruise->fgfTempCruise->temp_selected_index = $index;
			$packageCruise->fgfTempCruise->fgf_temp_cruise_detail_id = $result->db->id;
			$packageCruise->fgfTempCruise->save();
			$packageCruise->save();
		}
		return json_encode($result);
	}
	


		/* 
	| "$statusActive" is showing if you status active or not
	*/

	public function getAllCruises($packageDbId, $statusActive = true){

		$cruisesData = $this->cruisesRow($packageDbId);

		// dd_pre_echo($cruisesData);

		$bookedCruise = (object)[
			"count" => false, 
			"totalCost" => (object)[
					"inInr" => 0,"allCurrency" => (object)[]
				], 
			"cruisesResult" => []
		];

		$selectedCabin = [];

		if (count($cruisesData) >= 1) {
			foreach ($cruisesData as $cruiseData) {

					
				if (ifset($cruiseData->selected_cabin, 0)) {
					
					$selectedCabin = $cruiseData->selected_cabin;
					
					/*====================counting total selected cruise====================*/
					$bookedCruise->count +=  1;
					
					/*===================this is package_cruises table id===================*/
					$selectedCabin->checkInDate = $cruiseData->check_in_date;
					
					$selectedCabin->checkOutDate 
								= addDaysinDate($cruiseData->check_in_date,$cruiseData->nights);

					$selectedCabin->this_id = $cruiseData->id;
					$selectedCabin->route_id = $cruiseData->route_id;
					
					/*=====================getting cruise currency here=====================*/
					$PreferredCurrency = ifset($selectedCabin->PreferredCurrency, "INR");

					$roomPrice = ifset($selectedCabin->roomPrice, 0);
					$promotionRoomPrice = ifset($selectedCabin->promotionRoomPrice, 0);
					
					$selectedCabinPrice = $promotionRoomPrice != 0 
															? $promotionRoomPrice : $roomPrice;

					if (isset($bookedCruise->totalCost->allCurrency->$PreferredCurrency)) {
						$bookedCruise->totalCost->allCurrency->$PreferredCurrency += $selectedCabinPrice;
					}else{
						$bookedCruise->totalCost->allCurrency->$PreferredCurrency = $selectedCabinPrice;
					}

					/*======================pushing cruise result here======================*/
					$bookedCruise->cruisesResult[] = $selectedCabin;
				}
			}

			/*=========================pushing INR Cost here=========================*/
			$bookedCruise->totalCost->inInr = 
				ceil(getInrCost(rejson_decode(ifset($bookedCruise->totalCost->allCurrency, []), true)));
		};

		return $bookedCruise;
	}



	/*
	| this function is making to get complete full row of db using 
	| packageDbId which is package_id of package_cruise table 
	*/

	public function cruisesRow($packageDbId, $statusActive = true, $column = "*")
	{
		$activeWhere = $statusActive ? "`status` = 'Active' OR " : '';
		$result =  PackageCruiseModel::select($column)
					->whereraw("`package_id` = '$packageDbId' AND ($activeWhere `status` = 'occupied')")
					->get();
		return nested_jsonDecode(makeObject($result));
	}

	public function deleteByRoute($routeDbId)
	{
		PackageCruiseModel::where('route_id', $routeDbId)->update(["status" => "Inactive"]);
		return true;
	}


	public function cruiseDays($cruiseDay = 0)
	{
		if ($cruiseDay == 1) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 2) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 3) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 4) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 5) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 6) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 7) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}else{
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}

		return $itinerary;
		
	}

}
