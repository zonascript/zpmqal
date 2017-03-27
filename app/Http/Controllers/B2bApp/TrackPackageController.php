<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// ========================Models========================
use App\Models\B2bApp\TrackPackageModel;

class TrackPackageController extends Controller
{
	public static function call()
	{
		return new TrackPackageController;
	}

	public function model()
	{
		return new TrackPackageModel;
	}


	public function index()
	{
		$auth = Auth::user();
		$tracks = TrackPackageModel::select()
							->where(['user_id' => $auth->id])
								->get();
		return view('b2b.protected.dashboard.pages.track.index', ["tracks" => $tracks]);
	}

	/*
	| this function is to track when client opened the package
	*/
	public function opened($packageId)
	{
		$this->inactiveOld($packageId);
		$auth = Auth::user();
		$trackPackage = new TrackPackageModel;
		$trackPackage->user_id = isset($auth->id) ? $auth->id : '';
		$trackPackage->package_id = $packageId;
		$trackPackage->save();
		return $trackPackage;
	}


	public function inactiveOld($packageId)
	{
		return TrackPackageModel::where('package_id', $packageId)
															->update(['status' => 0]);
		
	}

	public function activeTracks()
	{
		$auth = Auth::user();
		
		$result = [];

		if ($auth->id) {
			$result = TrackPackageModel::select()
								->where([
											'user_id' => $auth->id,
											'status' => 1
										])
									->get();
		}
		return $result;
	}


	public function getActiveJson()
	{
		$activeTracks = $this->activeTracks();
		$tracks = [];
		if ($activeTracks->count()) {
			foreach ($activeTracks as $track) {
				$tracks[] = [
						"pid" => $track->package->id,
						"package_id" => $track->package->uid,
						"name" => $track->package->client->fullname,
						"date" => $track->created_at->format('Y-m-d H:i:s')
					];
			}
		}

		return json_encode($tracks);
	}

}
