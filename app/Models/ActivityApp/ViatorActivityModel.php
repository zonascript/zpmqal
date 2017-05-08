<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViatorActivityModel extends Model
{
	protected $connection = 'mysql6';
	protected $appends = ['vendor'];
	protected $table = 'viator_activities';

	public static function call(){
		return new ViatorActivityModel;
	}

	public function getVendorAttribute()
	{
		return 'v';
	}

	public function findByCode($code)
	{
		$columns  = [
				'id', 'code', 'primaryDestinationId as  destinationCode', 
				'currencyCode as currency', 'title as name', 
				'shortDescription as description',  
				'rank', 'thumbnailURL as image'
			];

		return $this->select($columns)->where(['code' => $code])->first();
	}


	public function findByDestination($cityId, $name = null)
	{
		$where = [
						"primaryDestinationId" => $cityId,
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

}
