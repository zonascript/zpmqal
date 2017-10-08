<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\PdfController;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PdfHtmlController;
use App\Http\Controllers\B2bApp\PackageCostsController;
use App\Http\Controllers\B2bApp\TrackPackageController;
use App\Http\Controllers\B2bApp\PackageCodesController;
use App\Http\Controllers\B2bApp\PackageNotesController;
use App\Http\Controllers\CommonApp\UrlController;
use App\Models\B2bApp\PackageModel;
use App\Mail\PackageMail;
use App\Traits\CallTrait;


class PackageController extends Controller
{
	use CallTrait;
	protected $viewPath = 'b2b.protected.dashboard.pages.package';

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
	public function index(Request $request){
		$packages = $this->model()->byUser()
								->search($request->search)
									->orderBy('id', 'desc')
										->simplePaginate(25);
		return view($this->viewPath.'.index', compact('packages'));
	}


	public function show($token, Request $request){
		$client = ClientController::call()->model()
							->byToken($token)->firstOrFail();
		
		$code = extract_int($request->search);
		
		$package = $client->packages();

		if($code) $package->byPackageCode($code);

		$bladeData = [
				"client" => $client,
				"packages" => $package->simplePaginate(20)
			];

		return view($this->viewPath.'.show', $bladeData);
	}


	public function open($token)
	{
		$package = $this->model()->byUser()->byToken($token)->firstOrFail();
		TrackPackageController::call()->inactiveOld($package->id);
		$bladeData = [
					"package" => $package,
					"viewPath" => $this->viewPath,
				];
		return view($this->viewPath.'.open',$bladeData);
	}

	
	public function notModifiable()
	{
		return view($this->viewPath.'.not_modifiable');
	}

	/*$pid is "package id"*/
	public function packageUpdate($pid, $request)
	{
		$package = PackageModel::byUser()->find($pid);

		if (!is_null($package)) {
			if (isset($request->start_date)) {
				$package->start_date = $request->start_date;
			}

			if (isset($request->end_date)) { 
				$package->end_date = $request->end_date;
			}

			if (isset($request->req)){
				$package->req = $request->req;
			}

			$package->route_status = 1;
			$package->save();
			$package->fixRouteDates();
			
			if (!is_null($package->cost)) {
				$costParams = (object)[
													"currency" => "INR", 
													"isVisa" => 0,
													"visaCost" => 0, 
													"netCost" => 0, 
													"margin" => 0
												];

				PackageCostsController::call()
							->createNew($package->id, $costParams);
			}

			if (isset($request->guests_detail)) {
				RoomGuestsController::call()
						->createNewMulti($package->id, $request->guests_detail);
			}
		}
		return $package;
	}


	public function createTemp($id, $request = [])
	{

		$newCode = isset($request->package_code) 
						 && !is_null($request->package_code)  
						 ? $request->package_code
						 : PackageCodesController::call()->model()->newCode();

		$auth = auth()->user();
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


	public function createPdfHtml($pid){

		$auth = auth()->user();
		$package = PackageModel::find($pid);
		$pdfHtmlId = null;
		if ($package->client->user_id == $auth->id) {
			$texts = $auth->admin->texts;

			$bladeData = [
				"package" => $package,
				"texts" => $texts,
			];

			$html = view($this->viewPath.'.pdf', $bladeData)->render();
			$pdfHtmlId = PdfHtmlController::call()->createNew($pid, $html);
		}
		return $pdfHtmlId;
	}
	

	
	public function getCreatePdfHtml($pid)
	{
		$pdfHtml = $this->createPdfHtml($pid);

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
		$package = $this->model()->byToken($token)->first();
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


	public function saveNote($token, Request $request)
	{
		$package = $this->model()->byToken($token)->first();
		$noteId = PackageNotesController::call()
							->creatOrUpdate(
										$package->package_note_id, 
										$request->note
									);
							
		$package->package_note_id = $noteId;
		$package->save();

		return json_encode([
								"status" => 200, 
								"response" => "saved successfully...",
								"id" => $noteId
							]);
	}



	public function sendPackageEmail($token, Request $request)
	{
		$package = $this->model()->byToken($token)->first();

		$data = (object)[
				"email" => $package->client->email,
				"name" => $package->client->fullname,
				"package" => $package,
				"subject" => $package->clientEmailSubject()
			];

		\Mail::to($data)->send(new PackageMail($data));

		return json_encode([
				"status" => 200,
				"response" => 'email sent successfully'
			]);
	}

	/*
	| this function it to get all event of the package;
	*/
	public function findEvent($value, $findType = 'id', $current = '')
	{
		if ($findType == 'token') {
			$package = $this->model()->byUser()
									->byToken($value)->firstOrFail();
		}
		else {
			$package = $this->model()->findOrFail($value);
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
