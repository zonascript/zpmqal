<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

// ================================B2bApp Controller===============================
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\ActivitiesController;
use App\Http\Controllers\B2bApp\DestinationController;

// ==============================HotelApp Controller===============================
use App\Http\Controllers\HotelApp\HotelsController as DbHotelsController;
/*use App\Http\Controllers\HotelApp\BookingHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelRoomsController;
use App\Http\Controllers\HotelApp\AgodaHotelDetailsController;*/

// =================================Api Controller=================================
use App\Http\Controllers\Api\TbtqHotelApiController;
use App\Http\Controllers\Api\SkyscannerHotelApiController;

// =====================================Model======================================
use App\Models\B2bApp\PackageHotelModel;

class HotelsController extends Controller
{

	public static function call(){
		return new HotelsController;
	}

	public function model(){
		return new PackageHotelModel;		
	}

	/*
	| this function is to find hotel by route table id which is route_id
	*/
	public function findByRouteId($routeId, $column = '*'){
		return PackageHotelModel::select($column)
															->where(['route_id' => $routeId])
																->first();
	}


	/*
	| this function is to get view on the browser using get request
	*/
	public function getHotelsByToken($token)
	{
		$package = PackageController::call()->model()->findByTokenOrExit($token);
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		return trimHtml(view('b2b.protected.dashboard.pages.hotels.index', $blade)->render());
	}



	/* 
	| this function is to insert or create new row in db
	*/
	public function createNew($object)
	{
		$packageHotel = new PackageHotelModel;
		$packageHotel->status = "active";
		$packageHotel->save();
		return $packageHotel->id;
	}


	public function postAddHotelRoom($routeId, Request $request)
	{
		$route = RouteController::call()->model()->find($routeId);
		$packageHotelId = $request->hdid;
		$packageHotel = $this->model()->find($packageHotelId);
		
		if (is_null($packageHotel)) {
			$packageHotel = $this->model();
			$packageHotel->hotel_code = $request->hid;
			$packageHotel->vendor = $request->hvdr;
			$packageHotel->save();
			$packageHotelId = $packageHotel->id;
			$route->fusion_id = $packageHotelId;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageHotelModel';
			$route->status = 'complete';
			$route->save();
		}

		$packageRooms = $packageHotel->roomModel();
		$packageRooms->package_hotel_id = $packageHotel->id;
		$packageRooms->roomtype_code = $request->rmid;
		$packageRooms->vendor = $request->rmvdr;
		$packageRooms->save();

		return json_encode([
				"hdid" => $packageHotelId,
				"rmdid" => $packageRooms->id
			]);

	}


	public function postRemoveHotel($rid, Request $request)
	{
		$route = RouteController::call()->model()->find($rid);
		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';
		$route->save();
		return json_encode(['status' => '200', 'reponse' => 'delete']);
	}


	public function postRemoveHotelRoom($rid, Request $request)
	{
		$route = RouteController::call()->model()->find($rid);
		$count = $route->fusionCount($route->fusion_id);
		$result = [
				"hdid" => '',
				"rooms" => [],
				"status" => 200, 
				"is_copied" => 0,
				"reponse" => "delete",
			];

		if ($count > 1) {
			$packageHotel = $this->model();
			$packageHotel->hotel_code = $route->fusion->hotel_code;
			$packageHotel->vendor = $route->fusion->vendor;
			$packageHotel->save();
			$packageHotelId = $packageHotel->id;
			$result['is_copied'] = 1;
			$result['hdid'] = $packageHotelId;
			if ($route->fusion->packageRooms->count()) {
				foreach ($route->fusion->packageRooms as $packageRoom) {
					if ($packageRoom->id != $request->rmdid) {
						$packageHotelRoom = $this->model()->roomModel();
						$packageHotelRoom->package_hotel_id = $packageHotelId;
						$packageHotelRoom->roomtype_code = $packageRoom->roomtype_code;
						$packageHotelRoom->vendor = $packageRoom->vendor;
						$packageHotelRoom->save();
						$result['rooms'][$packageRoom->id] = $packageHotelRoom->id;
					}
				}
			}
			$route->fusion_id = $packageHotel->id;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageHotelModel';
			$route->status = 'complete';
			$route->save();
		}
		else {
			$this->model()->roomModel()->destroy($request->rmdid);
		}

		return json_encode($result);
	}


	// this is not using but it can be use 
	public function postSelectedHotel($rid)
	{
		$route = RouteController::call()->model()->find($rid);
		$hotel = json_encode($route->fusion->hotelForView());
		return $hotel;
	}


	/*
	| this function is to delete data by using route id
	| it only make status into "Inactive" 
	*/
	public function deleteByRoute($routeDbId)
	{
		return PackageHotelModel::where('route_id', $routeDbId)
															->update(["status" => "inactive"]);
	}


	// this function is make global array for hotel api
	public function makeApiRequestData($data)
	{
		$request = null;

		if (!is_null($data)) {

			$startDate = $data->route->start_datetime->format('d/m/Y');
			$endDate =  $data->route->end_datetime->format('d/m/Y');

			// this is global request array
			$request = [
					"Destination" => $data->route->location_hotel,
					"RoomGuests" => $data->route->package->roomGuest,
					"Nights" => $data->route->nights,
					"PreferredCurrency" => "INR",
					"Dates" => [
							"CheckInDate" => $startDate,
							"CheckOutDate" => $endDate,
						],
				];

			$request = rejson_decode($request);
		}
		return $request;
	}


	/* 
	| this function is to pull hotel rooms data using post mrthod
	*/
	public function postHotelRoom(Request $request)
	{
		$params = [
				"id" => $request->hid,
				"vendor" => $request->vdr
			];
		$rooms = DbHotelsController::call()->hotelRooms($params);
		return json_encode($rooms);
	}



	public function removeHotelRoom($id)
	{
		$packageHotel =  PackageHotelModel::find($id);
		$packageHotel->selected_hotel_vendor = '';
		$packageHotel->status = 'active';
		$packageHotel->save();
		return $packageHotel;
	}



	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postTbtqHotelResult($id)
	{
		// return file_get_contents(public_path('faker\tbtq.json'));

		$packageHotel = PackageHotelModel::call()->usersFind($id);
		$params = $this->makeApiRequestData($packageHotel);
		$result = null;

		if (!is_null($params)) {
			$result = TbtqHotelApiController::call()->hotel($params);
		}

		if (isset($result->db->id)) {
			$packageHotel->tbtq_temp_hotel_id = $result->db->id;
			$packageHotel->save();
		}

		return json_encode($result);
	}



	/*
	| this function is to pull data from Skyscanner api using 
	| SkyscannerHotelApiController and it can be call using http post request
	*/
	public function postSkyscannerHotelResult($id)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);

		$result = '';

		if (!is_null($packageHotel)) {
			$result = SkyscannerHotelApiController::call()->hotels($packageHotel);
		}

		if (isset($result->db->id)) {
			$packageHotel->skysacanner_temp_hotel_id = $result->db->id;
			$packageHotel->save();
		}

		return json_encode($result);
	}


	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postHotelFromDb($routeId, $index = 0)
	{
		$route = RouteController::call()->model()->find($routeId);
		$selected = [];
		if (!is_null($route->fusion)) {
			$selected = json_decode(json_encode($route->fusion->hotelForView()));
		}

		$location = $route->dbDestination();
		$params = [
				'latitude' => $location->latitude, 
				'longitude' => $location->longitude, 
				'max_rating' => 5,
				'min_rating' => 0
			];
		$hotels = DbHotelsController::call()->hotels($params); 
		$hotels = json_decode(json_encode($hotels));
		$hotels = array_merge($selected, $hotels);
		$result = (object)['hotels' => $hotels];
		return json_encode($result);
	}

	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postHotelFromRename($id, Request $request)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);
		$location = $packageHotel->route->dbDestination();
		$result = (object)['hotels' => []];

		if (strlen($request->name) > 3) {
			$params = [
					'name' => $request->name,
					'latitude' => $location->latitude, 
					'longitude' => $location->longitude, 
					'max_rating' => 5,
					'min_rating' => 0,
				];
			$result->hotels = DbHotelsController::call()->hotels($params); 
		}

		return json_encode($result);
	}


	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postFgfAgodaHotelResult($id, $index = 0)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);

		$result = (object)['hotels' => []];

		if (isset($packageHotel->route->destination_agoda->city_id)) {
			$result->hotels = AgodaHotelsController::call()
							 ->hotels($packageHotel->route->destination_agoda->city_id, $index);
		}

		return json_encode($result);
	}


	public function postFgfAgodaHotelRoomResult($id, Request $request)
	{
		$agodaHotelId = $request->hid;
		$result = AgodaHotelRoomsController::call()->hotelRoom($agodaHotelId);
		return json_encode($result);
	}

	public function postFgfAgodaHotelDetail($id, Request $request)
	{
		$agodaHotelId = $request->hid;
		$result = AgodaHotelDetailsController::call()->hotelDetail($agodaHotelId);
		return $result; 
	}


	public function searchHotels($id, Request $request)
	{
		$packageHotel = PackageHotelModel::find($id);
		$location = $packageHotel->route->dbDestination();
		$params = [
					'name' => $request->name,
					'latitude' => $location->latitude, 
					'longitude' => $location->longitude, 
					'max_rating' => 5,
					'min_rating' => 0,
				];
				
		$hotelNames = DbHotelsController::call()
									->searchHotels($params);
		$result = ['hotels' => $hotelNames];

		if ($request->format == 'json') {
			$result = json_encode($result);
		}
		return $result;
	}


	public function searchHotelNames($id, Request $request)
	{
		$packageHotel = PackageHotelModel::find($id);
		$location = $packageHotel->route->dbDestination();
		$params = [
					'name' => $request->term,
					'latitude' => $location->latitude, 
					'longitude' => $location->longitude, 
					'max_rating' => 5,
					'min_rating' => 0,
					'is_name' => 1
				];
				
		$hotelNames = DbHotelsController::call()
									->searchHotelsByName($params);

		if ($request->format == 'json') {
			$hotelNames = json_encode($hotelNames);
		}

		return $hotelNames;
	}


	public function findHotel($id, Request $request)
	{
		$packageHotel = PackageHotelModel::find($id);
		$cityId = $packageHotel->route->destination_agoda->city_id;
		$hotel = AgodaHotelsController::call()
						->searchHotelByName($cityId, $request->name);
		
		$hotel = json_encode(["hotels" => $hotel]);

		return $hotel;
	}



}
