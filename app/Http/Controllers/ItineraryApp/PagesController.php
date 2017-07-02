<?php

namespace App\Http\Controllers\ItineraryApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\UrlController;
use App\Http\Controllers\B2bApp\PackageController;

class PagesController extends Controller
{
	public function pages($token, $page=null,  Request $request)
	{
		$package = PackageController::call()
								->model()->findByTokenOrExit($token,false);

		$package->costToken = $request->ctk;
		// dd($package->routes[1]->fusion->cruise->itinerary);

		if ($package->cost->total_cost < 1) {
			exitView();
		}


		$url = $request->fullUrl();
		if (is_null($page)) {
			$page = 'home';
			$url = str_replace($token, $token.'/'.$page, $url);
		}
		$tempUrl = str_replace($token.'/'.$page, $token.'/{}', $url);

		$urlObj = new UrlController(['url' => $tempUrl]);

		$blade = [
				"url" => $url,
				"package" => $package,
				"urlObj" => $urlObj,
				"token" => $token,
			];

		return view('subway.pages.'.$page, $blade);
	}



}
