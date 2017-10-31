<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class RouteRoomMapModel extends Model
{
	protected $table = 'route_room_maps';

	public function roomGuests()
	{
		return $this->hasMany(
											'App\Models\B2bApp\RoomGuestModel', 
											'route_room_map_id'
										);
	}

}
