<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class CruiseCabinModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'cruise_cabins';
	protected $hidden = ['vendor_detail_id', 'created_at', 'updated_at'];

	public function vendor()
	{
		return $this->belongsTo('App\Models\Api\VendorDetailModel', 'vendor_detail_id');
	}

}
