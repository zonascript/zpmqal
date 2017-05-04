<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CruiseApp\CruiseOnlyDateModel;
use App\Models\B2bApp\PackageCruiseCabinModel;

class PackageCruiseModel extends Model
{
	protected $table = 'package_cruises';
	protected $appends = ['detail'];

	public static function call(){
		return new PackageCruiseModel;
	}

	public function cabinModel()
	{
		return new PackageCruiseCabinModel;
	}


	public function cabin()
	{
		return $this->belongsTo('App\Models\B2bApp\CruiseCabinModel', 'cruise_cabin_id');
	}

	public function packageCabins()
	{
		return $this->hasMany(
							'App\Models\B2bApp\PackageCruiseCabinModel', 
							'package_cruise_id'
						);
	}

	public function itinerary()
	{
		$result = $this->detail();
		return $result->itinerary;
	}

	public function images()
	{
		$images = [];
		$detail = $this->detail();
		foreach ($detail->images as $image) {
			$images[] = $image->url;
		}
		return $images;
	}
}
