<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\TrackPackageModel;
use App\Http\Controllers\B2bApp\PackageController;
use Auth;

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
		$blade = ["tracks" => $this->model()->fatchTracks()];
		return view('b2b.protected.dashboard.pages.track.index', $blade);
	}

	/*
	| this function is to track when client opened the package
	*/
	public function opened($packageId)
	{
		$this->inactiveOld($packageId);
		$trackPackage = new TrackPackageModel;
		$trackPackage->package_id = $packageId;
		$trackPackage->save();
		return $trackPackage;
	}


	public function inactiveOld($packageId)
	{
		return TrackPackageModel::where('package_id', $packageId)
															->update(['status' => 0]);
		
	}


	public function getActiveJson()
	{
		$activeTracks = $this->model()->activeTracks();
		$tracks = [];
		if ($activeTracks->count()) {
			foreach ($activeTracks as $track) {
				$tracks[] = [
						"pid" => $track->package->id,
						"package_id" => $track->package->uid,
						"url" => route('openPackage',$track->package->token),
						"name" => $track->package->client->fullname,
						"date" => $track->created_at->format('Y-m-d H:i:s')
					];
			}
		}

		return json_encode($tracks);
	}


	public function trackPing($token, Request $request)
	{
		$package = PackageController::call()
								->model()->findByToken($token);

		$track = $this->model()->find($request->id);

		if (is_null($track)) {
			$track = $this->model();
		}

		$track->package_id = $package->id;
		$track->ip = $request->ip();
		$track->time_duration += 5;
		$track->status = 1;
		$track->save();
		return json_encode([
					"status" => 200,
					"id" => $track->id,
			]);
	}

}
