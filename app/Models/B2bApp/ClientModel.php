<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class ClientModel extends Model
{

	protected $table = 'clients';
	protected $appends = ['uid'];

	public static function call(){
		return new ClientModel;
	}

	public function getUidAttribute()
	{
		return $this->prefix.str_pad($this->id, 7, '0', STR_PAD_LEFT);
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function packages(){
		return $this->hasMany('App\Models\B2bApp\PackageModel', 'client_id');
	}


	public function leadVendor(){
		return $this->belongsTo('App\Models\AdminApp\LeadVendorModel', 'lead_vendor_id');
	}


	public function findByUser($id = null)
	{
		$auth = Auth::user();
		$where = ['user_id' => $auth->id];
		if ($id) $where['id'] = $id;

		return $this->where($where)->first();
	}


	public function findByUserOrExit($id)
	{
		$result = $this->findByUser($id);
		if (is_null($result)) {
			$this->exitView();
		}
		return $result;
	}

	public function exitView()
	{
		$blade = ["url" => urlReport()];
		exit(view('b2b.protected.dashboard.404_main', $blade)->render());
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
