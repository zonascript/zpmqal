<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// ===============================B2b Controller===============================
use App\Http\Controllers\B2bApp\ClientController;

use Auth;
use Session;

class EnquiryController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$clients = ClientController::call()->all();
		return view(
							'b2b.protected.dashboard.pages.enquiry.index', 
							['clients' => $clients]
						);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$auth = Auth::user();

		$leadVendors = $auth->admin->leadVendors;
		$request = Session::has('request') ? Session::get('request') : [];
		$blade = [
				"leadVendors" => $leadVendors,
				"request" => $request
			];

		return view('b2b.protected.dashboard.pages.enquiry.create', $blade);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		Session::flash('request', (object) $request->input());

		$this->validate($request, [
			'vendor' => 'required',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);


		$client = ClientController::call()
							->model()
								->findByMobileEmail($request->mobile, $request->mobile);
		if (is_null($client)) {
			$auth = Auth::user();
			$client = ClientController::call()->model();
			$client->user_id = $auth->id;
			$client->lead_vendor_id = $request->vendor;
			$client->fullname = $request->fullname;
			$client->mobile = $request->mobile;
			$client->email = $request->email;
			// $client->note = $request->note;
			$client->status = 'active';
			$client->save();
		}
		else{
			$client->fullname = $request->fullname." (".$client->fullname.")";

			if ($client->mobile == $request->mobile) {
				$client->note = 'Other email: '.$client->email.'.';
			}
			elseif ($client->email == $request->email){
				$client->note = 'Other mob: '.$client->mobile.'.';
			}
			
			$client->mobile = $request->mobile;
			$client->email = $request->email;
			$client->status = 'active';
			$client->save();
		}

		return redirect(urlRouteCreate($client->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
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


	public function pending(Request $request)
	{
		$clients = ClientController::call()->pendingClients();
		return json_encode($clients);
	}
}
