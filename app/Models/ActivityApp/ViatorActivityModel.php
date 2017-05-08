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


	public function findByDestination($cityId)
	{
		return $this->select()
									->where([
												"primaryDestinationId" => $cityId,
												"is_active" => 1
											])
										->skip(0)
											->take(20)
												->get();
	}


	public function searchActivities($cityId, $name)
	{
		return $this->select()
									->where([
												"primaryDestinationId" => $cityId,
												["title", 'like', '%'.$name.'%'],
												"is_active" => 1
											])
										->skip(0)
											->take(20)
												->get();
	}

}
