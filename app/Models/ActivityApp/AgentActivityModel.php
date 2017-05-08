<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class AgentActivityModel extends Model
{
	protected $connection = 'mysql6';
	protected $table = 'agent_activities';
	protected $appends = ['vendor', 'image_url'];

	public static function call()
	{
		return new AgentActivityModel;
	}

	public function setAdminIdAttribute($value = '')
	{
		$this->attributes['admin_id'] = $this->checkUser();
	}

	public function getVendorAttribute()
	{
		return 'own';
	}

	public function getImageUrlAttribute()
	{
		return urlImage($this->image_path);
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


	public function findByDestination($cityId, $name = null)
	{
		$where = [
						"admin_id" => $this->checkUser(),
						"destination_code" => $cityId,
						"is_active" => 1
					];

		if (!is_null($name)) {
			$where[] = ["title", 'like', '%'.$name.'%'];
		}

		return $this->where($where)
									->skip(0)
										->take(20)
											->get();
	}
	

	public function checkUser()
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

		return $adminId;
	}



	public function __construct(array $attributes = [])
	{
		$this->setAdminIdAttribute();
		parent::__construct($attributes);
	}
}
