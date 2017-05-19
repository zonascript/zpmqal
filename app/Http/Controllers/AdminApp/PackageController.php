<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\BackendApp\PlansController;

use App\Models\AdminApp\PackageModel;
use Auth;
use Payment;

class PackageController extends Controller
{

	public function getShowPlans()
	{
		$plans = PlansController::call()->model()->all();
		$viewPath = 'admin.protected.dashboard.pages.plans';
		$blade = [
				'viewPath' => $viewPath,
				'plans' => $plans
			];
		return view($viewPath.'.index', $blade);
	}

	public function getCheckout(Request $request)
	{
		$auth = Auth::guard('admin')->user();
		$plan = PlansController::call()->model()->find($request->plan);
		$viewPath = 'admin.protected.dashboard.pages.checkout';
		
		$blade = [
				'viewPath' => $viewPath,
				'plan' => $plan,
				'product' => $plan->name,
				'txnid' => uid()
			];

		if ($plan->with_price) {
			$blade['price'] = round($plan->price, 2);
			$blade['tax'] = round($plan->tax, 2);
			$duration = daysToMonth($plan->duration);
			$duration = $duration > 12 ? 12 : $duration;
			$duration .= $duration > 1 ? ' Months' : ' Month';
			$blade['duration'] = $duration;
		}
		else{
			$blade['price'] = $request->amount;
			$blade['tax'] = round($request->amount*.15, 2);
			$blade['duration'] = 'Unlimited';
		}
		
		$blade['payumoney'] = round(($blade['price']+$blade['tax'])*.029, 2);
		$blade['total'] = $blade['price']+$blade['tax']+$blade['payumoney'];
		return view($viewPath.'.index', $blade);
	}

	public function showInvoice($txnid)
	{
		$blade = [
				"productinfo" => $request->productinfo,
				"txnid" => $request->txnid,
				"name" => $request->firstname,
				"paymentId" => $request->encryptedPaymentId,
				"amount" => $request->amount,
				"addedon" => $request->addedon
			];
		return view('admin.protected.dashboard.pages.payumoney.success', $blade);
	}


}
