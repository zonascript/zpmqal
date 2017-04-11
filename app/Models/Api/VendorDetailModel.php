<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class VendorDetailModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'vendor_details';


	public function images()
	{
		return $this->hasMany('App\Models\Api\ImageModel', 'cancat(prefix, id)', 'relationId')
	}
}
