<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// ====================================B2b Contrller====================================
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PackageController;

use Auth;


ini_set('max_execution_time', 300);

class PackageBuilderController extends Controller
{


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return redirect('dashboard/enquiry/create');    
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 |
	 | this is belongs to route 
	 | http://.../dashboard/package/create/{id //this is client_id }
	 |
	 */
	// -----------------------this function is no longer used-----------------------
	public function create($id){

		return redirect('dashboard/package/route/'.$id);
		/*$bladeData = ["client" => ClientController::call()->info($id)];
		return view('b2b.protected.dashboard.pages.package_builder.route', $bladeData);*/

	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 |
	 | this is belongs to route of the post request on the same of create but it is for
	 | posting and saving data
	 | http://.../dashboard/package/create/{id //this is client_id }
	 |
	 */
	public function store($id, Request $request)
	{
    $package = PackageController::call()->model();
    $auth = Auth::user();
    $package->client_id = $id;
    $package->start_date = date_formatter($request->ArrivalDate,'d/m/Y');
    $package->end_date = date_formatter($request->DepartureDate,'d/m/Y');
    $package->guests_detail = json_encode(json_decodemulti($request->RoomGuests));
    $package->status = 'active';
    $package->user_id= $auth->id;
    $package->save();

		return json_encode(["nextUrl" => newRedirectUrl(urlPackageAll($id, $package->id))]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//get client information
		$client = ClientController::call()->info($id);
		//get package information

		//make blade array

		/*$bladeData = [
				"client" => $client,
				"packageId" => 'FGF'.str_pad($packageDbId, 5, '0', STR_PAD_LEFT),
				"packageDbId" => $packageDbId,
		];*/

		return view('b2b.protected.dashboard.pages.package_itinerary_all', ["client" => $client]);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

}
