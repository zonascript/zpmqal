<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class AgentActivityModel extends Model
{
	protected $table = 'agent_activities';
	protected $appends = ['vendor'];
	protected $connection = 'mysql2';

	public static function call()
	{
		return new AgentActivityModel;
	}


	public function getVendorAttribute()
	{
		return 'own';
	}


	public function setAdminIdAttribute($value)
	{
		$adminId = null;
		$auth = Auth::user();
		$domain = $_SERVER['HTTP_HOST'];
		if (in_array($domain, [env('B2B_DOMAIN'), env('LOCAL_B2B_DOMAIN')])) {
			$adminId = $auth->id;
		}
		elseif (in_array($domain, [env('ADMIN_DOMAIN'), env('LOCAL_ADMIN_DOMAIN')])) {
			$adminId = $auth->admin->id;
		}
		
		$this->attributes['admin_id'] = $adminId;
	}


	public function findByCode($id)
	{
		
		$columns = [
				'id', 'id as code', 
				'destination_code as destinationCode', 
				DB::raw('\'INR\' as currency'), 
				'title as name', 'description', 
				'status', DB::raw('\'0\' as rank'),
				DB::raw('CONCAT(\''.urlImage().'\', image_path) as image')
			];

		return $this->select($columns)->where(['id' => $id])->first();
	}
}
