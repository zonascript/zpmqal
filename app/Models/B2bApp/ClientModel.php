<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\ClientAliasModel;

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


	public function aliases()
	{
		return $this->hasMany(ClientAliasModel::class, 'client_id');
	}

	public function leadVendor(){
		return $this->belongsTo('App\Models\AdminApp\LeadVendorModel', 'lead_vendor_id');
	}


	public function findByUser($id = null)
	{
		$auth = auth()->user();
		$where = ['user_id' => $auth->id];
		if ($id) $where['id'] = $id;

		return $this->where($where)->first();
	}


	public function findByUserOrExit($id)
	{
		$result = $this->findByUser($id);
		if (is_null($result)) {
			exitView();
		}
		return $result;
	}


	public function findByMobileEmail($mobile, $email)
	{
		$auth = auth()->user();
		$client = $this->select()
							->where([
										"user_id" => $auth->id,
										["status", "<>", "deleted"]
									])
								->where(function ($query) use ($mobile, $email){
											$query->where(["mobile" => $mobile])
														->orWhere(["email" => $email]);
										})
									->first();
		
		return $client;
	}


	public function duplicateOrNew($mobile, $email)
	{
		$client = $this->findByMobileEmail($mobile, $email);

		if (!is_null($client)) {
			$alias = new ClientAliasModel;
			$alias->client_id = $client->id;
			$alias->user_id = $client->user_id;
			$alias->lead_vendor_id = $client->lead_vendor_id;
			$alias->fullname = $client->fullname;
			$alias->mobile = $client->mobile;
			$alias->email = $client->email;
			$alias->created_at = $client->updated_at;
			$alias->save();
		}
		else{
			$client = new ClientModel;
		}

		return $client;
	}

}
