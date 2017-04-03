<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViatorActivityModel extends Model
{
	protected $connection = 'mysql2';
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
				'shortDescription as description', 'status', 
				'rank', 'thumbnailURL as image'
			];

		return $this->select($columns)->where(['code' => $code])->first();
	}

}
