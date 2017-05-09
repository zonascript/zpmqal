<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//====================================Model====================================
use App\Models\Api\UberTokenModel;

class UberTokenController extends Controller
{
	public static function call()
	{
		return new UberTokenController;
	}

	public function fatchToken()
	{
		return UberTokenModel::select()->orderBy('id', 'desc')->first();
	}

	public function storeToken($request)
	{
		
		$token = new UberTokenModel;
		$token->scope = $request->scope;	
		$token->token_type = $request->token_type;	
		$token->expires_in = $request->expires_in;	
		$token->access_token = $request->access_token;	
		$token->refresh_token = $request->refresh_token;	
		$token->refresh_before = $request->refresh_before;	
		$token->last_authenticated = $request->last_authenticated;	
		$token->save();
		return true;
	}
}
