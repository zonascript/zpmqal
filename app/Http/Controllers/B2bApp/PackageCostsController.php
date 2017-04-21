<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==========================Models==========================
use App\Models\B2bApp\PackageCostModel;

class PackageCostsController extends Controller
{
	public static function call()
	{
		return new PackageCostsController;
	}

	public function model()
	{
		return new PackageCostModel;
	}

	public function createNew($packageDbId, $request)
	{
		$packageCost = new PackageCostModel;
		$packageCost->package_id = $packageDbId;
		$packageCost->currency = $request->currency;
		$packageCost->is_visa = isset($request->isVisa) ? $request->isVisa : 0;
		$packageCost->visa_cost = $request->visaCost;
		$packageCost->net_cost = $request->netCost;
		$packageCost->margin = $request->margin;
		$packageCost->save();
		return $packageCost;
	}


}
