<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class RoomGuestModel extends Model
{
	protected $table = 'room_guests';
	protected $hidden = ['created_at', 'updated_at'];

	public function childAge()
	{
		return $this->hasMany('App\Models\B2bApp\ChildAgeModel', 'room_guest_id');
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
