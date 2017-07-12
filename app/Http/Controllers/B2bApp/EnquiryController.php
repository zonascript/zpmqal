<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\ClientController;

class EnquiryController extends Controller
{
	public $viewPath = 'b2b.protected.dashboard.pages.enquiry';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$auth = auth()->user();
		$clients = ClientController::call()
							->model()
								->where([
											'user_id' => $auth->id,
											['status', '<>', 'deleted'],
											['fullname', 'like', '%'.$request->search.'%']
										])
									->simplePaginate(20);

		return view($this->viewPath.'.index', ['clients' => $clients]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$auth = auth()->user();

		$leadVendors = $auth->admin->leadVendors;
		$blade = [
				"leadVendors" => $leadVendors,
			];

		return view($this->viewPath.'.create', $blade);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'vendor' => 'required',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);


		$client = ClientController::call()->model()
							->duplicateOrNew($request->mobile, $request->mobile);

		$auth = auth()->user();
		$client->user_id = $auth->id;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->status = 'active';
		$client->save();

		return redirect()->route('createRoute',$client->id);
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
