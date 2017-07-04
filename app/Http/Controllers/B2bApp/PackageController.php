<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =================================B2b Contrller=================================
use App\Http\Controllers\B2bApp\PdfController;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PdfHtmlController;
use App\Http\Controllers\B2bApp\PackageCostsController;
use App\Http\Controllers\B2bApp\TrackPackageController;
use App\Http\Controllers\B2bApp\PackageCodesController;

// ===============================Common Contrller=================================
use App\Http\Controllers\CommonApp\UrlController;

// =====================================Models=====================================
use App\Models\B2bApp\PackageModel;

// =====================================Session====================================
use Session;
use Auth;


class PackageController extends Controller
{
	protected $viewPath = 'b2b.protected.dashboard.pages.package';

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


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($id){
		$client  = ClientController::call()->model()->findByUserOrExit($id);
		$bladeData = [
				"client" => $client,
				"packages" => $client->packages
			];

		return view($this->viewPath.'.index', $bladeData);
	}


	public function open($token)
	{
		$package = $this->model()->findByTokenOrExit($token);
		dd($package);
		TrackPackageController::call()->inactiveOld($package->id);
		$bladeData = [
					"package" => $package,
					"viewPath" => $this->viewPath,
				];
		return view($this->viewPath.'.show',$bladeData);
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

		$newCode = isset($request->package_code) && !is_null($request->package_code)  
						 ? $request->package_code
						 : PackageCodesController::call()->model()->newCode();

		$auth = Auth::user();
		$package = $this->model();
		$package->user_id= $auth->id;
		$package->client_id = $id;
		$package->package_code = $newCode;
		$package->modify_count = $package->modifiedCount($newCode);

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

			$html = view($this->viewPath.'.pdf', $bladeData)->render();
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
					"response" => "something went wrong"
				];

		if (!is_null($pdfHtml)) {
			$return['status'] = 200;
			$return['hash_id'] = $pdfHtml->hash_id;
			$return['response'] = 'done';
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


	public function saveCost($token, Request $request)
	{
		$package = $this->model()->findByToken($token);
		if (!$package->is_locked) {
			$package->is_locked = 1;
			$package->save();
		}

		$costParams = (object)[
				"currency" => "INR", 
				"isVisa" => $request->visa,
				"visaCost" => $request->visaCost,
				"netCost" => $request->netCost, 
				"margin" => $request->margin
			];

		$packageCost = PackageCostsController::call()
										->createNew($package->id, $costParams);

		return json_encode([
								"status" => 200, 
								"response" => "saved successfully...",
								"token" => $packageCost->token
							]);
	}


	/*
	| this function it to get all event of the package;
	*/
	public function findEvent($value, $findType = 'id', $current = '')
	{
		if ($findType == 'token') {
			$package = $this->model()->findByTokenOrExit($value);
		}
		else{
			$package = $this->model()->findOrExit($value);
		}

		$token = $package->token;
		$nextUrl = url();

		if ($package->activeFlightRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/flights/'.$token);
		}
		elseif ($package->activeAccomoRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/accommodation/'.$token);
		}
		elseif($package->hotelRoutes->count() && $current != 'activities'){
			$nextUrl = url('dashboard/package/builder/activities/'.$token);
		}
		else{
			$nextUrl = route('openPackage',$token);
		}
		/*elseif ($package->activeHotelRoutes->count()) {
			$nextUrl = url('dashboard/package/builder/hotels/'.$token);
		}
		elseif($package->activeCruiseRoutes->count()){
			$nextUrl = url('dashboard/package/builder/cruises/'.$token);
		}*/
		return json_encode(["nextUrl" => $nextUrl]);
	}
	

	public function getFindEvent($token, $current)
	{
		$result = $this->findEvent($token, 'token', $current);
		$result = json_decode($result);
		return redirect($result->nextUrl);
	}


	public function makePackageRaplica($pid)
	{
		$package = $this->model()->find($pid);
		$newPackage = $this->createTemp($package->client_id, $package);
		$package->copyRoomGuests($newPackage->id);
		RouteController::call()->copyRoutes($package->id, $newPackage->id);
		return $newPackage;
	}


}
