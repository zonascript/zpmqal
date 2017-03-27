<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===============================Models===============================
use App\Models\AdminApp\LeadVendorModel;

use Session;

class LeadVendorController extends Controller
{

	public static function call()
	{
		return new LeadVendorController;
	}

	public function model()
	{
		return new LeadVendorModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$where = "CONCAT(`company_name`, '', `contact_person`, ' ', `contact_number`, ' ', `email_id`) LIKE '%".$request->v."%'";

		$vendors = $this->model()->findByAdminId(null, [], $where);

		$blade = [
				"vendors" => $vendors,
			];

		return view('admin.protected.dashboard.pages.lead_vendor.index', $blade); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.protected.dashboard.pages.lead_vendor.create'); 
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
			'company_name' => 'required|max:255',
			'contact_person' => 'required|max:255',
			'contact_number' => 'numeric',
			'email_id' => 'email|max:255',
			'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$user = userdetail();

		$leadVendorModel = new LeadVendorModel;
		$leadVendorModel->admin_id = $user->id;
		$leadVendorModel->company_name = $request->company_name;
		$leadVendorModel->contact_person = $request->contact_person;
		$leadVendorModel->contact_number = $request->contact_number;
		$leadVendorModel->email_id = $request->email_id;
		$leadVendorModel->address = $request->address;
		$leadVendorModel->website = $request->website;
		$leadVendorModel->note = $request->note;

		if (!is_null($request->logo)) {
			$leadVendorModel->image_path = imageUpload($request->logo);
		}
		else{
			$leadVendorModel->image_path = 'images/default/profile.jpg';
		}
		
		$leadVendorModel->status = 'active';

		$leadVendorModel->save();

		Session::flash('success', 'Contact added successfully!');

		return redirect('dashboard/settings/lead/vendor');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$vendor = LeadVendorModel::find($id);
		$blade = ["vendor" => $vendor];
		return view('admin.protected.dashboard.pages.lead_vendor.show', $blade); 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$vendor = LeadVendorModel::find($id);
		$blade = ["vendor" => $vendor];
		return view('admin.protected.dashboard.pages.lead_vendor.edit', $blade); 
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
			'company_name' => 'required|max:255',
			'contact_person' => 'required|max:255',
			'contact_number' => 'numeric',
			'email_id' => 'email|max:255',
			'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$user = userdetail();

		$leadVendorModel = LeadVendorModel::find($id);
		$leadVendorModel->admin_id = $user->id;
		$leadVendorModel->company_name = $request->company_name;
		$leadVendorModel->contact_person = $request->contact_person;
		$leadVendorModel->contact_number = $request->contact_number;
		$leadVendorModel->email_id = $request->email_id;
		$leadVendorModel->address = $request->address;
		$leadVendorModel->website = $request->website;
		$leadVendorModel->note = $request->note;

		if (!is_null($request->logo)) {
			$leadVendorModel->image_path = imageUpload($request->logo);
		}
		
		$leadVendorModel->status = 'active';

		$leadVendorModel->save();

		Session::flash('success', 'Contact added successfully!');

		return redirect('dashboard/settings/lead/vendor');
	}


	/*
	| this function to active vendor
	*/
	public function active($id)
	{
		$vendor = LeadVendorModel::find($id);
		$vendor->status = 'active';
		$vendor->save();
		return redirect('dashboard/settings/lead/vendor');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $request)
	{
		$vendor = LeadVendorModel::find($id);
		
		if (isset($request->inactive)) {
			$vendor->status = 'inactive';
		}elseif (isset($request->delete)) {
			$vendor->status = 'deleted';
		}

		$vendor->save();
		return redirect('dashboard/settings/lead/vendor');
	}
}
