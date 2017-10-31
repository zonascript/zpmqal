<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class RoomGuestModel extends Model
{
	protected $table = 'room_guests';
	protected $hidden = ['created_at', 'updated_at', 'guest_details'];

	public function getGuestDetailsAttribute()
	{
		return collect([
				'id' 			 => $this->id,
				'adults' 	 => $this->no_of_adult,
				'kids' 		 => $this->childAge->pluck('details')->count(),
				'kids_age' => $this->childAge->pluck('details')
			]);
	}

	public function childAge()
	{
		return $this->hasMany('App\Models\B2bApp\ChildAgeModel', 'room_guest_id');
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	public function routes()
	{
		return $this->hasMany(
											'App\Models\B2bApp\RouteModel',
											'route_room_map_id', 'route_room_map_id'
										);
	}





	public function scopeByUser($query)
	{
		return $query->whereHas('package', function ($q){
								$q->byUser();
							});
	}


	public function childAgeIds()
	{
		return $this->childAge->pluck('details');
	}


	public function copyGuests($pid)
	{
		$newGuest = $this;
		if ($this->id) {
			$newGuest = $this->replicate();
			$newGuest->package_id = $pid;
			$newGuest->save();
			foreach ($this->childAge as $childAge) {
			 	$childAge->copyChildAge($newGuest->id);
			} 
		}
		return $newGuest;
	}


}
