<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Auth;
class AgentActivityModel extends Model
{
	protected $table = 'agent_activities';
	protected $connection = 'mysql2';

	public function call()
	{
		return new AgentActivityModel;
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
}
