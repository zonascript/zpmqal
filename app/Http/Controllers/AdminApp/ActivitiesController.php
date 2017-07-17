<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\ImageController;
use App\Http\Controllers\ActivityApp\AgentActivitiesController;


class ActivitiesController extends Controller
{

	public $viewPath = 'admin.protected.dashboard.pages.activity';

	public function call()
	{
		return new ActivitiesController;
	}

	public function model()
	{
		return AgentActivitiesController::call()->model();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$params = [
				'title'	=> $request->search,
				'destCode' => $request->city,
			];

		$activities = $this->model()->activitiesPaginate($params);

		return view($this->viewPath.'.index', compact('activities'));
	}


	public function createOrEdit($id = null)
	{
		$activity = $this->model()->findCheckUser($id);

		if (is_null($activity)) {
			$activity = $this->model();
		}

		return view($this->viewPath.'.create', compact('activity'));
	}


	public function storeOrUpdate(Request $request)
	{
		$activity = $this->model()->findCheckUser($request->id);
		$activity->class;
		if (is_null($activity)) {
			$activity = $this->model();
		}

		$activity->title =  $request->title;
		$activity->description =  $request->description;
		$activity->destination_code =  $request->dest_code;
		$activity->save();
		$images = isset($request->images) && is_array($request->images) 
						? $request->images
						: [];

		ImageController::call()->model()->makeAndSave(
				$images, $activity->id,
				'App\Models\ActivityApp\AgentActivityModel'		
			);

		if ($request->format == 'json') {
			return json_encode([
					"status" => 200,
					"response" => "saved successfully."
				]);
		}
		return redirect('dashboard/inventories/activity');
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return redirect('dashboard/inventories/activity/store');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$activity = $this->model()->findOrExit($id);
		return view($this->viewPath.'.show', compact('activity'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return redirect('dashboard/inventories/activity/store/'.$id);
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
		$activity = $this->model()->findOrExit($id);
		$activity->delete();
		return redirect('dashboard/inventories/activity');
	}


	public function deactivate($id)
	{
		$this->changeStatus($id, 0);
		return redirect('dashboard/inventories/activity');
	}


	public function activate($id)
	{
		$this->changeStatus($id, 1);
		return redirect('dashboard/inventories/activity');
	}

	public function changeStatus($id, $status)
	{
		$activity = $this->model()->findOrExit($id);
		$activity->is_active = $status;
		$activity->save();
		return $this;
	}

}
