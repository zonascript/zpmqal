<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

use App\Http\Controllers\AdminApp\EnquiryController;

class DashboardController extends Controller
{

	public function getIndex(){
		$clients = EnquiryController::call()->model()->findByAdminId();
		$blade = [
				"clients" => $clients
			];
		return view('admin.protected.dashboard.pages.index.index', $blade);
	}

	public function getSlug($page = 'index')
	{
		if (View::exists('admin.protected.dashboard.pages.'.$page)) {
			// $client = ClientController::call()->all();
			

			// /*
			// | this is for time or clock which is showing time,
			// | in that checking into that array which is second paramenter 
			// | that page is in array if yes then show clock
			// */
			// $onload = '';
			// if (in_array($page, ['index'])) {
			// 	$onload = 'onload=startTime()';
			// }

			// // ===============================Blade Object===============================

			// $blade = (object)[
			// 		"other" => (object)["onload" => $onload],
			// 	];


			return view('admin.protected.dashboard.pages.'.$page, []);
		}
		else{
			return view('errors.404');
		}
	}
}
