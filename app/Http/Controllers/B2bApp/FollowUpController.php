<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\FollowUpModel;

class FollowUpController extends Controller
{

	public $viewPath = 'b2b.protected.dashboard.pages.follow_up';

	public static function call(){
		return new FollowUpController;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$auth = auth()->user();
		$name = $request->search;
		$fups = FollowUpModel::select()
					->with('package')
					->where([
								'status' => 'active', 
								'user_id' => $auth->id
							])
					->whereHas('package', function ($q) use ($name){
								$q->with('client')
									->where([['id', '>', 1]])
									->whereHas('client', function ($q) use ($name){
												$q->where([['fullname', 'like', '%'.$name.'%']]);
											});
							})
					->whereRaw("`datetime` > now()")
					->simplePaginate(25);

		return view($this->viewPath.'.index', ["follow_ups" => $fups]);
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
		$res = [
					"status" => 200,
					"response" => "Something went wrong"
				];
		if ($request->pid) {
			$auth = auth()->user();
			$followUp = new FollowUpModel;
			$followUp->user_id = $auth->id;
			$followUp->package_id = $request->pid;
			$followUp->datetime = $request->datetime;
			$followUp->note = $request->followup;
			$followUp->status = 'active';
			$followUp->save();
			$res['response'] = "saved successfully...";
		}

		return json_encode($res);
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


	// ======this function to fatch all follow up from db======
	public function all()
	{
		$auth = auth()->user();

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
