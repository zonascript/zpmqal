<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;

class CruiseCabinModel extends Model
{
	protected $connection = 'mysql5';
	protected $table = 'cruise_cabins';
	protected $appends = ['vendor', 'cabintype'];
	protected $hidden = ['vendor_detail_id', 'created_at', 'updated_at'];


	public function getVendorAttribute()
	{
		return 'f';
	}

	public function getCabinTypeAttribute()
	{
		return $this->cabin_code.'-'.$this->cabin;
	}

	public function vendorDetail()
	{
		return $this->belongsTo('App\Models\CruiseApp\VendorDetailModel', 'vendor_detail_id');
	}

}
