<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqDestinationModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_destinations';
	protected $appends = ['location'];
	protected $hidden = ['created_at', 'updated_at'];


	public function getLocationAttribute()
	{
		return $this->destination.', '.$this->country;
	}

	public function scopeByDestinationCode($query, $code)
	{
		return $query->where('destination_code', $code);
	}

	public function scopeBySearch($query, $name)
	{
		return $query->where('country', 'like', '%'.$name.'%')
									->orWhere('destination', 'like', '%'.$name.'%');
	}

}
