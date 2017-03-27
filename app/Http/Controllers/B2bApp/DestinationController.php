<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===============================Api Controller===============================
use App\Http\Controllers\Api\DestinationController as DestinationApiController;

// ===============================B2b Controller===============================
use App\Http\Controllers\B2bApp\RouteController;

// ====================================Model===================================
use App\Models\B2bApp\DestinationModel;
use App\Models\BackendApp\ViatorDestinationModel;

class DestinationController extends Controller
{
	/*
	| Call the DestinationApiController's method or property here 
	*/
	public static function api()
	{
		return new DestinationApiController;
	}

	public static function call()
	{
		return new DestinationController;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($destination = '', $routeDbId = '')
	{   
		if ($routeDbId != '') {
			exit(view('b2b.protected.dashboard.pages.destination.create', 
				["destination" => $destination,  "route_id" => $routeDbId]
			));
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// dd($request->input());

		$route = RouteController::call()->find($request->route_id);
		$route->destination = $request->destination;
		$route->save();
		return redirect('/dashboard/package/event/'.$request->route_id);
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



	/*
	| this function is for finding destination from a string 
	| like if we have an string "SIN, Changi, Singapore, Singapore | Singapore, Singapore"
	| then this function will take word after "|" and search behalf of that 
	| else it will take complete string and this will return $city_id mean table id 
	| if not found this will return 
	*/

	public function search($string='', $routeDbId = '', $isExit = true)
	{

		$destination = explode(' | ', $string);
		$destination = ifset($destination[1], $destination[0]);
		$destination = $this->api()->search($destination);
		
		if (is_null($destination) && $isExit){
			
			/*
			| if destination is not found the stopped here for run more code 
			| and returned view for selecting destination
			*/
			$this->create($string, $routeDbId);
		}

		return $destination;
	}


	public function viatorSearch($word = '')
	{
		$result = ViatorDestinationModel::select()
							->where(['destinationName' => $word])
								->orWhere([['destinationName', 'like', "%".$word."%"]])
									->first();
		return $result;
	}




}
