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

// =================================Api Controller=================================
use App\Http\Controllers\Api\AgodaHotelsController;
use App\Http\Controllers\Api\TbtqHotelApiController;
use App\Http\Controllers\Api\AgodaHotelRoomsController;
use App\Http\Controllers\Api\AgodaHotelDetailsController;
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
	| this function is to find hotel by hotel table id
	*/
	public function find($id){
		return PackageHotelModel::find($id);
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
	public function getHotelsByPackageId($packageDbId)
	{
		$package = PackageController::call()->model()->usersFind($packageDbId);
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		// dd($package->hotelRoutes[0]->location_hotel);
		return view('b2b.protected.dashboard.pages.hotels.index', $blade);
	}




	public function book($id){
		PackageHotelModel::call()->book($id);
	}


	/* 
	| this function is to insert or create new row in db
	*/
	public function createNew($object)
	{
		$packageHotel = $this->isExist($object->route_id);
		
		if (is_null($packageHotel)) {
			$packageHotel = new PackageHotelModel;
		}

		$packageHotel->route_id = $object->route_id;
		$packageHotel->status = "active";
		$packageHotel->save();

		return $packageHotel->id;
	}



	/*
	| this function is to create new hotel table row using route data 
	*/
	public function createNewByRoute($routeDbId)
	{
		$params = (object)['route_id' => $routeDbId];
		$result = $this->createNew($params);

		// =========this function is to create new activity row in db=========
		ActivitiesController::call()->createNew($params);

		return $result;

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




	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($routeDbId)
	{
		$packageHotel = PackageHotelModel::select()
										->where([
													"route_id" => $routeDbId,
												])
											->first();

			return $packageHotel;
	}



	/*
	| this function is to pull hotels result from api 
	*/
	public function getHotel($packageHotelId)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($packageHotelId);
		
		// dd($packageHotel->route);

		// $requestParams = $this->makeApiRequestData($packageHotel);
		// if (!is_null($requestParams)) {
			
		// 	// =========================Tbtq hotels here=========================
		// 	$tbtqResult = TbtqHotelApiController::call()->hotel($requestParams);
		// 	$getCurrentCart->tbtq_temp_hotel_id = $tbtqResult->db->id;
		// 	$getCurrentCart->save();

			// ==========================blade data here=========================
			$bladeData = [
				"package" => $getCurrentCart->package,
				"client"    =>  $getCurrentCart->package->client,
				"packageHotel" => $getCurrentCart,
				"destination" => $requestParams->destination,
				"hotelResults" => (object)["tbtq" => $tbtqResult]
			];

			return view('b2b.protected.dashboard.pages.hotel.get_hotel', $bladeData);
		// }
		// else{
		// 	return view('errors.404');
		// }
	}

	public function getHotelView($packageHotelId)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($packageHotelId);
		$bladeData = [
				"packageHotel" => $packageHotel,
				"package" => $packageHotel->route->package,
				"client" =>  $packageHotel->route->package->client,
			];

		return view('b2b.protected.dashboard.pages.hotel.get_hotel_view', $bladeData);
	}

	// this function is make global array for hotel api
	public function makeApiRequestData($data)
	{
		$request = null;

		if (!is_null($data)) {

			$startDate = date_formatter($data->route->start_date, 'Y-m-d H:i:s');
			$endDate =  addDaysinDate($startDate, $data->route->nights);

			// this is global request array
			$request = [
				"Destination" => $data->route->location_hotel,
				"RoomGuests" => $data->route->package->roomGuest,
				"Dates" => [
					"CheckInDate" => $startDate,
					"CheckOutDate" => $endDate,
				],
				"PreferredCurrency" => "INR",
			];

			$request = rejson_decode($request);
		}
		return $request;
	}


	/* 
	| this function is to pull hotel rooms data using post mrthod
	*/
	public function postHotelRoom($packageHotelId, Request $request)
	{
		$getCurrentCart = PackageHotelModel::call()->usersFind($packageHotelId);
		$hotelRoom = null;

		if (!is_null($getCurrentCart)) {
			if ($request->vendor == 'tbtq') {
				$hotelRoom = TbtqHotelApiController::call()
										->hotelRoom($getCurrentCart->tbtq_temp_hotel_id, $request->index);

			}
			elseif ($request->vendor == 'ss') {
				$hotelRoom = SkyscannerHotelApiController::call()
										->hotelDetail($getCurrentCart->skysacanner_temp_hotel_id, $request->index);
			}
			
			$bladeData = [
					"requestIndex" => $request->index, 
					"vendor" => $request->vendor,
					"hotelRoom" => $hotelRoom,
				];

			return view('b2b.protected.dashboard.pages.hotel.post_hotel_room', $bladeData);
		}
		else{
			return "Something Went Wrong please try again later.";
		}
	}



	/*
	| this function it to final the room
	*/
	public function postBookHotelRoom($packageHotelId, Request $request)
	{
		/*
		| vdr = vendor
		| apk = agent_prices key
		| rok = room_offers key
		| rk = rooms key
		| hid = hotel id
		| rmid = room id
		| pu =  pick_up
		|	pus = pick_up_selected
		|	do = drop_off
		|	dos = drop_off_selected
		*/

		$packageHotelModel = new PackageHotelModel;
		$getCurrentCart = $packageHotelModel->usersFind($packageHotelId);
		$getCurrentCart->route->is_pick_up = $request->pus;
		$getCurrentCart->route->pick_up = $request->pu;
		$getCurrentCart->route->is_drop_off = $request->dos;
		$getCurrentCart->route->drop_off = $request->do;
		$getCurrentCart->route->save();

		if (!is_null($getCurrentCart)) {
			// storing vendor in db
			$getCurrentCart->selected_hotel_vendor = $request->vdr;

			// checking which vendor is selected
			if ($request->vdr == 'tbtq') {
				// if vendor is tbtq then copying tbtq_temp_hotel_id to tbtq_hotel_id
				$getCurrentCart->tbtq_hotel_id = $getCurrentCart->tbtq_temp_hotel_id;
				// calling tbtq book function here
				TbtqHotelApiController::call()
									->book($getCurrentCart->tbtq_temp_hotel_id, $request->tk);
			}
			elseif($request->vdr == 'ss'){
				$getCurrentCart->skysacanner_hotel_id =  $getCurrentCart->skysacanner_temp_hotel_id;
				SkyscannerHotelApiController::call()
									->book($getCurrentCart->skysacanner_temp_hotel_id, $request);
			}
			elseif($request->vdr == 'a'){
				$getCurrentCart->agoda_hotel_id =  $request->hid;
				$getCurrentCart->agoda_hotel_room_id =  $request->rmid;
			}// if there is another api provider then using elseif here to define next 

			$routeDbId = $getCurrentCart->route_id;
			$getCurrentCart->status = 'occupied';
			$getCurrentCart->save();
			
			//====================telling this route is complete====================
			RouteController::call()->complete($routeDbId);

			$returnArray = [ 
				"status" => 200,
				"packageUrl" => newRedirectUrl(urlPackageAll($getCurrentCart->route->package->client->id, $getCurrentCart->route->package->id)),
				"nextUrl" => newRedirectUrl(urlPackageEvent($routeDbId)),
			];

			return json_encode($returnArray);
		}
		else{
			
			$returnArray = [ 
				"status" => 200,
				"packageUrl" => url($packageDbId),
				"nextUrl" => url($packageDbId),
			];

			return json_encode($returnArray);
		}
	}

	public function removeHotelRoom($id)
	{
		$packageHotel =  PackageHotelModel::find($id);
		$packageHotel->selected_hotel_vendor = '';
		$packageHotel->status = 'active';
		$packageHotel->save();
		return $packageHotel;
	}

	public function postRemoveHotelRoom($id)
	{
		$packageHotel = $this->removeHotelRoom($id);
		$result = [
				'status' => 500, 
				'responce' => 'removing failed'
			];

		if (!is_null($packageHotel)) {
			$result = [
					'status' => 200, 
					'responce' => 'removed successfully'
				];
		}
		return json_encode($result);
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
		$cityId = $packageHotel->route->destination_agoda->city_id;
		$hotelNames = AgodaHotelsController::call()
									->searchHotelsByName($cityId, $request->term);

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
