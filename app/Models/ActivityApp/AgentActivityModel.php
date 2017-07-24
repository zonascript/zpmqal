<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
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
		return	$this->images->count()
					? $this->images[0]->url
					: urlImage('images/default/activity.png');
	}


	public function images()
	{
		return $this->morphMany('App\Models\CommonApp\ImageModel', 'connectable');
	}


	public function destination()
	{
		return $this->belongsTo('App\Models\CommonApp\DestinationModel', 'destination_code');
	}


	public function status()
	{
		return $this->belongsTo('App\Models\CommonApp\IndicationModel', 'is_active');
	}


	public function scopeAdminId($query)
	{
		return $query->where([
											'admin_id' => $this->checkUser()
										]);
	}

	public function findOrExit($id)
	{
		return $this->where([
											'id' => $id,
										])
									->firstOrFail();
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
	

	public function activitiesPaginate(Array $params)
	{
		$params = (object) $params;
		$where = [
							['title', 'like', '%'.$params->title.'%'],
							'admin_id' => $this->checkUser()
						];

		if (isset($params->destCode)) {
			$where['destination_code'] = $params->destCode;
		}

		return $this->where($where)->simplePaginate(20);
	}


	public function checkUser()
	{
		$adminId = null;

		$domain = $_SERVER['HTTP_HOST'];
		if ($domain == env('B2B_DOMAIN')) {
			$auth = auth()->user();
			$adminId = $auth->id;
		}
		elseif ($domain == env('ADMIN_DOMAIN')) {
			$auth = auth()->guard('admin')->user();
			$adminId = $auth->id;
		}

		return $adminId;
	}


	public function openUrl()
	{
		return url('dashboard/inventories/activity/'.$this->id);
	}



	public function __construct(array $attributes = [])
	{
		$this->setAdminIdAttribute();
		parent::__construct($attributes);
	}
}
