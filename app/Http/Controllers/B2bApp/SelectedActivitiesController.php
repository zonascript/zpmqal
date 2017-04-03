<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\SelectedActivityModel;

class SelectedActivitiesController extends Controller
{
	public static function call()
	{
		return new SelectedActivitiesController;
	}


	public function inactiveOld($packageActivityId)
	{
		SelectedActivityModel::where(['package_activity_id' => $packageActivityId])
													 ->update(['is_active' => 0]);
		return $this;
	}


	public function bulkInsert($data)
	{
		SelectedActivityModel::insert($data);
		
		return $this;
	}

}
