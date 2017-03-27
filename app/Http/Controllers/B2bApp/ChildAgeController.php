<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ================================Models================================
use App\Models\B2bApp\ChildAgeModel;

class ChildAgeController extends Controller
{
	public static function call()
	{
		return new ChildAgeController;
	}

	/*
	| this function is for bulk insert
	|	$data = [
	|			['room_guest_id' => 3, 'age'=> 3],
	|			['room_guest_id' => 3, 'age'=> 4],
	|		];
	*/
	public function bulkInsert($params)
	{
		$result = ChildAgeModel::insert($params);
	}

}
