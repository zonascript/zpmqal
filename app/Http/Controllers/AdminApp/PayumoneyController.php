<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminApp\PayuPaymentModel;
use Auth;

class PayumoneyController extends Controller
{
	private $data = [
			"auth" => null,
			"mode" => 'secure',
			"testUrl" => 'https://test.payu.in/_payment',
			"secureUrl" => 'https://secure.payu.in/_payment',
			"surl" => '',
			"furl" => '',
		];

	public static function call()
	{
		return new PayumoneyController;
	}

	public function model()
	{
		return new PayuPaymentModel;
	}

	public function pay(Request $request)
	{
		$this->mode = 'test';

		// user detail here
		$name = $this->auth->firstname;
		$email = $this->auth->email;
		$phone = $this->auth->mobile;

		// Request data here
		$txnid = $request->txnid;
		$amount = $request->amount;
		$productinfo = !is_null($request->product) 
								 ? $request->product
								 : 'product';

		// hashing here
		$hashseq = $this->key.'|'.$txnid.'|'.$amount.'|'
								.$productinfo.'|'.$name.'|'.$email
									.'|||||||||||'.$this->salt;

		$hash = strtolower(hash("sha512", $hashseq)); 	

		$blade = [
			"url" => $this->url,
			"key" => $this->key,
			"salt" => $this->salt,
			"surl" => $this->surl,
			"furl" => $this->furl,
			"name" => $name,
			"hash" => $hash,
			"txnid" => $txnid,
			"phone" => $phone,
			"email" => $email,
			"amount" => $amount,
			"hashseq" => $hashseq,
			"productinfo" => $productinfo,
		];
		return view('admin.protected.dashboard.pages.payumoney.index', $blade);
	}


	public function success(Request $request)
	{
		$request->is_success = 1;
		$payu = $this->store($request);
		return is_null($payu) ? $this->exitView() :
		redirect()->route('showInvoice', $payu->txnid);
	}


	public function exitView()
	{
		$blade = ["url" => urlReport()];
		exit(view('b2b.protected.dashboard.404_main', $blade)->render());
	}

	public function store(Request $request)
	{
		$payu = null;
		if (isset($request->txnid)) {
			$payu = $this->model()->findByTxnid($request->txnid);
			if (is_null($payu)) {
				$payu = $this->model();
				$payu->txnid = $request->txnid;
				$payu->payable_id = $this->auth->id;
				$payu->payable_type = 'App\\Admin';
				$payu->is_success =  $request->is_success;
				$payu->data = $request->input();
				$payu->save();
			}
		}
		return $payu;
	}


	public function failure(Request $request)
	{
		$request->is_success = 0;
		$payu = $this->store($request);
		return is_null($payu) ? $this->exitView() :
		redirect()->route('showInvoice', $payu->txnid);
	}


	public function getUrlAttribute()
  {
    return 'tzsk-payu';
  }

	public function __construct()
	{
		$this->surl = url('agent/pay/success');
		$this->furl = url('agent/pay/failure');
	}


	public function __set($name, $value)
	{
		if (isset($this->data[$name])) {
			$this->data[$name] = $value;
		}
		else{
			$this->$name = $value;
		}
	}

	public function __get($name)
	{
		$data = (object) $this->data;
		$value = null;

		if ($name == 'auth') {
			if (is_null($this->data['auth'])) {
				$this->data['auth'] = Auth::guard('admin')->user();
			}
			$value = $this->data['auth'];
		}
		elseif(isset($this->data[$name])) {
			$value = $this->data[$name];
		}
		elseif ($this->mode == 'secure'){
			if ($name == 'url') {
				$value = $data->secureUrl;
			}
			elseif ($name == 'key') {
				$value = env('PAYUMONEY_KEY');
			}
			elseif ($name == 'salt') {
				$value = env('PAYUMONEY_KEY');
			}
		}
		elseif ($this->mode == 'test') {
			if ($name == 'url') {
				$value = $data->testUrl;
			}
			elseif ($name == 'key') {
				$value = env('TEST_PAYUMONEY_KEY');
			}
			elseif ($name == 'salt') {
				$value = env('TEST_PAYUMONEY_SALT');
			}
		}
		return $value;
	}
}
