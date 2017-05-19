<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==================================Models==================================
use App\Models\AdminApp\TextModel;

use Auth;

class TextController extends Controller
{

	public function call()
	{
		return new TextController;
	}

	public function model()
	{
		return new TextModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$auth = Auth::guard('admin')->user();

		$where = "CONCAT(`title`, '', `text`) LIKE '%".$request->t."%'";
		
		$texts = $this->model()->findByAdminId(null, [], $where);

		$blade = ["texts" => $texts];
		return view('admin.protected.dashboard.pages.text.index', $blade); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.protected.dashboard.pages.text.create'); 
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
				"title" => "required|max:255",
				"text" => "required"
			]);

		$auth = Auth::guard('admin')->user();
		$maxOrder = $this->maxOrderNumber();
		$maxOrderNumber = 1;
		if (!is_null($maxOrder) && !is_null($maxOrder->order)) {
			$maxOrderNumber = $maxOrder->order+1;
		}

		$text = new TextModel;
		$text->admin_id = $auth->id;
		$text->order = $maxOrderNumber;
		$text->title = $request->title;
		$text->text = $request->text;
		$text->status = 'active';
		$text->save();

		return redirect('dashboard/settings/text');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$auth = Auth::guard('admin')->user();
		$text = TextModel::find($id);

		if (!is_null($text) && $text->admin_id == $auth->id) {
			
			$blade = ["text" => $text];

			return view('admin.protected.dashboard.pages.text.show', $blade); 
		}
		else{
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
		$auth = Auth::guard('admin')->user();
		$text = TextModel::find($id);

		if (!is_null($text) && $text->admin_id == $auth->id) {
			
			$blade = ["text" => $text];

			return view('admin.protected.dashboard.pages.text.edit', $blade); 
		}
		else{
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
				"title" => "required|max:255",
				"text" => "required"
			]);

		$auth = Auth::guard('admin')->user();
		$text = TextModel::find($id);
		$text->admin_id = $auth->id;
		$text->title = $request->title;
		$text->text = $request->text;
		$text->status = 'active';
		$text->save();

		return redirect('dashboard/settings/text');
	}

	/*
	| this function to active vendor
	*/
	public function active($id)
	{
		$text = TextModel::find($id);
		$text->status = 'active';
		$text->save();
		return redirect('dashboard/settings/text');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $request)
	{
		$text = TextModel::find($id);
		
		if (isset($request->inactive)) {
			$text->status = 'inactive';
		}elseif (isset($request->delete)) {
			$text->status = 'deleted';
		}

		$text->save();
		return redirect('dashboard/settings/text');
	}



	public function maxOrderNumber()
	{
		$auth = Auth::guard('admin')->user();
		return TextModel::select('order')
						->where(["admin_id" => $auth->id])
							->orderBy("order","desc")
								->first();
	}


}
