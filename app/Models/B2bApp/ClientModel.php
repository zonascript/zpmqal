<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class ClientModel extends Model
{

	protected $table = 'clients';

	public static function call(){
		return new ClientModel;
	}

	public function packages(){
		return $this->hasMany('App\Models\B2bApp\PackageModel', 'client_id');
	}


	public function leadVendor(){
		return $this->belongsTo('App\Models\AdminApp\LeadVendorModel', 'lead_vendor_id');
	}

	/*
	| this function also call for all client info 
	| for that you dont have to pass any thing
	*/
	public function selfInfo($id = false){

		$auth = Auth::user();
		
		$where = ['user_id' => $auth->id];

		if ($id) { $where['id'] = $id; }

		$client = $this->select('*', DB::raw("CONCAT(`prefix`,LPAD(`id`,5,0)) AS uid"))
										->where($where)
											->first();

		return $client;
	}


	public function findByMobileEmail($mobile, $email)
	{
		$client = $this->select()
							->where([["status", "<>", "deleted"]])
								->where(function ($query) use ($mobile, $email){
										$query->where(["mobile" => $mobile])
													->orWhere(["email" => $email]);
									})
									->first();
		return $client;
	}


}
