<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =================================B2b Contrller=================================
use App\Http\Controllers\B2bApp\PdfController;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\FlightsController;
use App\Http\Controllers\B2bApp\PdfHtmlController;
use App\Http\Controllers\B2bApp\ActivitiesController;
use App\Http\Controllers\B2bApp\PackageCostsController;
use App\Http\Controllers\B2bApp\TrackPackageController;


// =====================================Models=====================================
use App\Models\B2bApp\PackageModel;

// =====================================Session====================================
use Session;
use Auth;


class PackageController extends Controller
{

  public static function call(){
    return new PackageController;
	}

	/*
	| this function is to call model which is connected to this model 
	| every controller can only has one Model in most case 
	*/
	public function model(){
		return new PackageModel;
	}


	public function open($id)
	{
		$package = PackageModel::find($id);
		return redirect(urlPackageAll($package->client->id, $id));
	}


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id){
  	
  	$client  = ClientController::call()->info($id);
  	// dd($client->leadVendor);
		if (!is_null($client)) {

			$bladeData = [
					"client" => $client,
					"packages" => $client->packages
				];

			return view('b2b.protected.dashboard.pages.package.index', $bladeData);
		}
		else{
			return view('errors.404');
		}

	}


  // this if function is for storing and creating new row in db

  public function createNew($id, $request)
  {
  	$auth = Auth::user();
    $package = new PackageModel;
    $package->user_id= $auth->id;
    $package->client_id = $id;
    $package->start_date = $request->start_date;
    $package->end_date = $request->start_date;
    $package->req = $request->req;
    $package->status = 'active';
    $package->save();

    // ==============this function is to save multiple room data=============
		$guestsDetail = [
				"packageDbId" => $package->id, 
				"roomGuest" => json_decodeMulti($request->guests_detail),
			];

		$costParams = (object)[
											"currency" => "INR", 
											"isVisa" => 0,
											"visaCost" => 0, 
											"netCost" => 0,
											"margin" => 0
										];

		PackageCostsController::call()->createNew($package->id, $costParams);

		RoomGuestsController::call()->createNewMulti($guestsDetail);

    return $package;
  }

  public function packageUpdate($packageDbId, $request)
  {

    $package = PackageModel::find($packageDbId);

    if (!is_null($package)) {
    	if (isset($request->start_date)) $package->start_date = $request->start_date;
    	if (isset($request->end_date)) $package->end_date = $request->end_date;
    	if (isset($request->req)) $package->req = $request->req;
    	$package->route_status = 1;
	    $package->save();
    	$package->fixRouteDates();

	    // ==============this function is to save multiple room data=============
			$guestsDetail = [
					"packageDbId" => $package->id, 
					"roomGuest" => json_decodeMulti($request->guests_detail),
				];

			$costParams = (object)[
												"currency" => "INR", 
												"isVisa" => 0,
												"visaCost" => 0, 
												"netCost" => 0, "margin" => 0
											];

			PackageCostsController::call()->createNew($package->id, $costParams);
			RoomGuestsController::call()->createNewMulti($guestsDetail);
    }

	  return $package;
  }


  public function createTemp($id, $request = [])
  {
  	$auth = Auth::user();
    $package = new PackageModel;
    $package->user_id= $auth->id;
    $package->client_id = $id;
    $package->start_date = isset($request->start_date) 
    										 ? $request->start_date 
    										 : '0000-00-00';

    $package->end_date = isset($request->end_date)
    									 ? $request->end_date
    									 : '0000-00-00';

    $package->req = isset($request->req) ? $request->req : '';
    $package->status = 'active';
    $package->save();
    $package = $package->find($package->id);
    return $package;
  }

  public function storeGuestsDetail($id, $guestsDetail)
  {
  	$package = PackageModel::find($id);
  	$package->guests_detail = json_encode(json_decodemulti($guestsDetail));
  	$package->save();

  	return true;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
	public function show($id, $packageDbId){
		$package = PackageModel::call()->usersFind($packageDbId);
		TrackPackageController::call()->inactiveOld($packageDbId);

		if (isset($package->client->id) && $package->client->id == $id) {
			$bladeData = ["package" => $package];
			return view('b2b.protected.dashboard.pages.package.show',$bladeData);
		}
		else{
			return view('errors.404');
		}
	}




	public function createPdfHtml($packageDbId){

		$auth = Auth::user();
		$package = PackageModel::find($packageDbId);
		$pdfHtmlId = null;
		if ($package->client->user_id == $auth->id) {
			$texts = $auth->admin->texts;

			$bladeData = [
				"package" => $package,
				"texts" => $texts,
			];

			$html = view('b2b.protected.dashboard.pages.package.pdf', $bladeData)->render();
			$pdfHtmlId = PdfHtmlController::call()->createNew($packageDbId, $html);
		}
		return $pdfHtmlId;
	}

	
	public function getCreatePdfHtml($packageDbId)
	{
		$pdfHtml = $this->createPdfHtml($packageDbId);

		$return = [
					"status" => 500, 
					"hash_id" => 'error',
		 			"responce" => "something went wrong"
		 		];

		if (!is_null($pdfHtml)) {
			$return['status'] = 200;
			$return['hash_id'] = $pdfHtml->hash_id;
			$return['responce'] = 'done';
		}

		return json_encode($return);
	}



	public function getCreatePdf($hashId)
	{
		$pdfHtml = PdfHtmlController::call()->findByHashId($hashId);
		$html = $pdfHtml->html;
		$name = $pdfHtml->package->uid;
		return PdfController::call()->createPdf($name, $html);
	}



	public function showPackageHtml($pdfHtmlId)
	{
		$pdfHtml = PdfHtmlController::call()->find($pdfHtmlId);
		$html = $pdfHtml->html;
		$html = str_replace('<body', '<body style="border: 1px solid #ccc;width: 64%;margin: auto;"', $html);
		return $html;
	}



	public function getAllCompletePackages($id)
	{
		$packagesList = $this->getpackagesList($id, ["id", "client_id"]);
		if (bool_array($packagesList)) {
			$result = [];
			
			foreach ($packagesList as $key => $packageList) {
				$result[] = getCompletePackage($id, $packageList->id);
			}

			return $result;
		}
		else{
			return false;
		}
	}

	public function getpackagesList($id, $colunm = '*')
	{
		if (ClientController::call()->validClient($id)) {
			$result = PackageModel::select($colunm)
												->where(["client_id" => $id])
												->get();
			return $result->count() >= 1 ? $result : false;		
		}else{
			return false;
		}
	}

	public function saveCost($id, $packageDbId, Request $request)
	{
		$costParams = (object)[
				"currency" => "INR", 
				"isVisa" => $request->visa,
				"visaCost" => $request->visaCost,
				"netCost" => $request->netCost, 
				"margin" => $request->margin
			];

		$package = PackageModel::find($packageDbId);
		$packageCost = PackageCostsController::call()
									->inactiveByPackageId($package->id)
										->createNew($package->id, $costParams);

		return json_encode(["status" => 200, "responce" => "saved successfully..."]);
	}



	public function moveToOldCost($preTotalCost)
	{
		// $preTotalCost = makeObject($preTotalCost);

		$oldTotalCost = isset($preTotalCost->old) && is_array($preTotalCost->old) ? $preTotalCost->old : [];
		
		unset($preTotalCost->old);
		if (!empty($preTotalCost)) {
			$oldTotalCost[] = $preTotalCost;
		}

		return $oldTotalCost;
	}


	/*
	| this fucntion is for finding package from packages table 
	*/
	public function findPackage($id, $colunm = null, $clientDbId = null)
	{
			$colunm = is_null($colunm) ? '*' : $colunm;
			$clientDbId = is_null($clientDbId) ? '*' : $clientDbId;
			$result = PackageModel::call()->usersFind($id);
			return $result;
	}

	/*
	|
	*/
	public function findEvent($packageDbId)
	{
		$package = PackageModel::find($packageDbId);

		if ($package->routes->count()) {
			// creating rows in table by route
			foreach ($package->routes as $route) {
				$params = (object)['route_id' => $route->id];
				if ($route->mode == 'flight') {
					FlightsController::call()->createNew($params);
				}
				elseif ($route->mode == 'hotel') {
					HotelsController::call()->createNew($params);

					// =========this function is to create new activity row in db=========
					ActivitiesController::call()->createNew($params);
				}
				elseif ($route->mode == 'cruise') {
					CruisesController::call()->createNew($params);
				}
			}
		}

		$nextUrl = url();

		if ($package->activeFlightRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/flights/'.$packageDbId);
		}
		elseif ($package->activeHotelRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/hotels/'.$packageDbId);
		}
		elseif($package->activeCruiseRoutes->count()){
			$nextUrl = url('dashboard/package/builder/cruises/'.$packageDbId);
		}
		elseif($package->hotelRoutes->count()){
			$nextUrl = url('dashboard/package/builder/activities/'.$packageDbId);
		}else{
			$nextUrl = urlPackageAll($package->client->id, $package->id);
		}

		return json_encode(["nextUrl" => newRedirectUrl($nextUrl)]);
	}
	

	public function getFindEvent($packageDbId)
	{
		$result = $this->findEvent($packageDbId);
		$result = json_decode($result);
		return redirect($result->nextUrl);
	}


	public function findNextEvent($packageDbId, $current)
	{
		$package = PackageModel::find($packageDbId);

		$nextUrl = url();

		if ($package->activeFlightRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/flights/'.$packageDbId);
		}
		elseif ($package->activeHotelRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/hotels/'.$packageDbId);
		}
		elseif($package->activeCruiseRoutes->count()){
			$nextUrl = url('dashboard/package/builder/cruises/'.$packageDbId);
		}
		elseif($package->hotelRoutes->count()){
			$nextUrl = url('dashboard/package/builder/activities/'.$packageDbId);
		}else{
			$nextUrl = urlPackageAll($package->client->id, $package->id);
		}

		return redirect($nextUrl);
	}


	/*
	| this function is to get next event like flight or hotel
	| it must be return json with next url
	*/
	public function nextEvent($routeDbId)
	{	

		$route = RouteController::call()->find($routeDbId);
		$package = $route->package;
		$nextUrl = url();
		
		/* 
		| if current route is active which mean work on that untile it complete
		*/
		if ($route->status == 'active') {

			// ===================checking $events has value or not===================
			if ($route->mode == 'flight') {

				//=========================checking about flight=========================
				$newFlightId = FlightsController::call()->createNewByRoute($routeDbId);
				$nextUrl = urlFlightsResult($newFlightId);
			}
			elseif(in_array($route->mode, ['hotel', 'road', 'land'])){

				// =========================checking about hotel=========================
				$newHotelId = HotelsController::call()->createNewByRoute($routeDbId);
				$nextUrl = urlHotelsBuilder($newHotelId);
			}
			elseif($route->mode == 'cruise'){

				//=========================checking about cruise=========================
				$newCruiseId = CruisesController::call()->createNewByRoute($routeDbId);
				$nextUrl = urlCruisesBuilder($newCruiseId);
			}
		}
		else{
			$nextRouteid = RouteController::call()
										->findNextRoute($route->package_id, $routeDbId);

			// =======if route id is null then showing all activities here=======
			if (is_null($nextRouteid)) {
				// =======================Setting dates here=======================
				$this->setDates($route->package_id);
				$nextUrl = urlActivitiesBuilder($route->package_id);
			}
			else{
				return $this->nextEvent($nextRouteid);
			}
		}

		return json_encode(["nextUrl" => newRedirectUrl($nextUrl)]);

	}



	/*
	| this function is to get next event using get request from browser
	public function getEvent($packageDbId)
	{
		$result = $this->nextEvent($routeDbId);
		$result = json_decode($result);
		return redirect($result->nextUrl);
	}
	*/



	/*
	| this function is not necessary
	| it is only for showing this line in pdf 
	| "3Nights 4Day" 
	*/
	public function setDates($packageDbId)
	{
		$package = PackageModel::find($packageDbId);
		$routes = $package->routes;
		$package->start_date = $routes[0]->start_date;
		$package->end_date = $routes[$routes->count()-1]->end_date;
		$package->save();
	}


	public function dbCostSapr()
	{
		$packages = PackageModel::select('id', 'total_cost', 'created_at','updated_at')
															->get();

		// dd($packages[0]->total_cost);
		
		$costParams = [];
		foreach ($packages as $package) {
			$totalCost = $package->total_cost;
			if (isset($totalCost->old)) {
				$netCost = 0;
				foreach ($totalCost->old as $old) {
					$netCost = isset($old->totalCost) ? $old->totalCost : 0;
					$costParams[] = [
							"package_id" => $package->id,
							"currency" => "INR", 
							"net_cost" => $netCost, 
							"margin" => 0,
							"is_current" => 0,
							"created_at" => $package->created_at,
							"updated_at" => $package->updated_at,
						];
				}

				$costParams[] = [
						"package_id" => $package->id,
						"currency" => "INR", 
						"net_cost" => $netCost, 
						"margin" => 0,
						"is_current" => 1,
						"created_at" => $package->created_at,
						"updated_at" => $package->updated_at,
					];
			}
		}

		PackageCostsController::call()->model()->insert($costParams);
		// dd($costParams);
	}

}
