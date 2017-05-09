<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// ======================================Models======================================
use App\Models\B2bApp\FollowUpModel;

// =====================================Session======================================
use Session;
use Auth;

class FollowUpController extends Controller
{
	public static function call(){
		return new FollowUpController;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$follow_ups = $this->all();

		return view('b2b.protected.dashboard.pages.follow_up.index', ["follow_ups" =>$follow_ups]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$auth = Auth::user();

		$followUp = new FollowUpModel;
		$followUp->user_id = $auth->id;
		$followUp->packageId = $request->input('packageDbId');
		$followUp->fullname = $request->input('fullname');
		$followUp->datetime = $request->input('datetime');
		$followUp->note = $request->input('followup');
		$followUp->status = 'Active';
		$followUp->save();

		return json_encode(["status" => 200,"response" => "saved successfully..."]);
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


	// ==================this function to fatch all follow up from db==================
	public function all()
	{
		$auth = Auth::user();
		$result = FollowUpModel::select()
							->with('package')
								->where([
											'status' => 'active', 
											'user_id' => $auth->id
										])
									->whereRaw("`datetime` > now()")
										->get();

		return $result;
	}


}
