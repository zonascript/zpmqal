<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CommonApp\RedirectUrlModel;
use Auth;

class RedirectController extends Controller
{


	public static function call(){
		return new RedirectController;
	}

	/*
	| this function is to making new redirect url
	*/
	public function newUrl($url){
		$auth = Auth::user();

		$redirectUrl = RedirectUrlModel::create(["status" => "active", "user_id" => $auth->id]);
		$redirectUrl->token = csrf_token();
		$redirectUrl->hash_id = sha1('b2b_fgf'.$redirectUrl->id);
		$redirectUrl->url = $url;
		$redirectUrl->save();

		return url('/redirect/'.$redirectUrl->hash_id);
	}


	/*
	| this function to redirect on the url which is saved to database
	*/
	public function redirectNow($hashId){
		$redirectUrl = $this->findUrl($hashId);
		if ($redirectUrl != false && $redirectUrl != '') {
			return view('common.protected.pages.redirect', ["url" => $redirectUrl]);
		}
		else{
			return view('errors.404');
		}
	}

	/*
	| this function only for finding url
	*/
	public function findUrl($hashId){
		$findUrl = RedirectUrlModel::call()->findByHashId($hashId);
 		return isset($findUrl->url) ? $findUrl->url : false;
	}
	
}
