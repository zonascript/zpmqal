<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminApp\LeadVendorController;
use App\Models\AdminApp\EnquiryModel;



class EnquiryController extends Controller
{
	public static function call()
	{
		return new EnquiryController;
	}


	public function model()
	{
		return new EnquiryModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$clients = $this->model()->simplePaginateData('', true);
		return view('admin.protected.dashboard.pages.enquiry.index', ['clients' => $clients]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$auth = auth()->guard('admin')->user();
		$agents = $auth->users;
		$leadVendors = LeadVendorController::call()
									->model()->findByAdminId();

		$blade = [
				"agents" => $agents,
				"leadVendors" => $leadVendors,
			];

		return view('admin.protected.dashboard.pages.enquiry.create', $blade);
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
			'agent' => 'required|numeric',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);


		$client = new EnquiryModel;
		$client->user_id = $request->agent;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->note = $request->note;
		$client->status = 'pending';
		$client->save();

		return redirect('dashboard/enquiry');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$auth = auth()->guard('admin')->user();
		$enquiry = $this->model()->find($id);

		if (!is_null($enquiry) && $auth->id == $enquiry->user->admin->id) {
			$agents = $auth->users;
			$leadVendors = LeadVendorController::call()->model()->findByAdminId();
			$blade = [
					"agents" => $agents,
					"enquiry" => $enquiry,
					"leadVendors" => $leadVendors,
				];

			return view('admin.protected.dashboard.pages.enquiry.show', $blade);
		}else{
			return view('errors.404');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$auth = auth()->guard('admin')->user();
		$enquiry = $this->model()->find($id);

		if (!is_null($enquiry) && $auth->id == $enquiry->user->admin->id) {
			$agents = $auth->users;
			$leadVendors = LeadVendorController::call()->model()->findByAdminId();
			$blade = [
					"agents" => $agents,
					"enquiry" => $enquiry,
					"leadVendors" => $leadVendors,
				];

			return view('admin.protected.dashboard.pages.enquiry.edit', $blade);
		}else{
			return view('errors.404');
		}
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
		$this->validate($request, [
			'vendor' => 'required',
			'agent' => 'required|numeric',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);

		$client = $this->model()->find($id);
		$client->user_id = $request->agent;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->note = $request->note;
		$client->status = 'pending';
		$client->save();

		return redirect('dashboard/enquiry');
	}

	public function active($id)
	{
		$enquiry = $this->model()->find($id);
		$enquiry->status = 'active';
		$enquiry->save();
		return redirect('dashboard/enquiry');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $request)
	{
		$enquiry = $this->model()->find($id);

		if (isset($request->inactive)) {
			$enquiry->status = 'inactive';
		}
		elseif(isset($request->delete)){
			$enquiry->status = 'deleted';
		}

		$enquiry->save();
		return redirect('dashboard/enquiry');
	}
}
