<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqJsonHotelRoomModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_hotel_rooms';
	protected $appends = ['status'];
	protected $casts = ['request' => 'object', 'response' => 'object'];

	public $with = ['hotels'];

	public function getStatusAttribute()
	{
		return isset($this->response->GetHotelRoomResult->ResponseStatus)
				 ? $this->response->GetHotelRoomResult->ResponseStatus
				 : 0;
	}


	public function rooms()
	{
		if ($this->status != 1) return [];

		$rooms = [];

		foreach ($this->response->GetHotelRoomResult->HotelRoomsDetails as $key => $room) {

			$rooms[] = (object) [
								'id' => $key,
								'room_type' => $room->RoomTypeName,
								'price' => $room->Price->PublishedPriceRoundedOff,
								'inclusion' => $room->Inclusion,
								'cancellation_policy' => $room->CancellationPolicy,
								'sequence' => $room->SequenceNo,
								'source' => $room->InfoSource
							];
		}

		return $rooms;
	}


	public function roomsOld()
	{
		$rooms = [];
		if ($this->status == 1) {
			foreach ($this->response->GetHotelRoomResult->RoomCombinations->RoomCombination as $combinationKey => $combination) {
				$roomComb = (object)[
								'id' => $combinationKey,
								'room_type' => '',
								'price' => 0,
								'inclusion' => [],
								'cancellation_policy' => '',
							];

				foreach ($combination->RoomIndex as $roomIndex) {

					$room = $this->getRoomByRoomIndex($roomIndex);

					$roomComb->room_type .= $room->RoomTypeName;
					$roomComb->price += $room->Price->PublishedPriceRoundedOff;
					$roomComb->inclusion = array_merge(
																			$roomComb->inclusion, 
																			$room->Inclusion
																		);
					if ($roomComb->cancellation_policy != $room->CancellationPolicy) {
						$roomComb->cancellation_policy 
												.= $room->CancellationPolicy;
					}
				}

				$rooms[] = $roomComb;
			}
		}

		return $rooms;
	}


	public function hotels()
	{
		return $this->belongsTo(
					'App\Models\HotelApp\TbtqJsonHotelModel',
					'tbtq_json_hotel_id'
				);
	}


	public function hotel()
	{
		$hotel = null;
		
		if (!is_null($this->hotels)) {
			$hotel = $this->hotels->hotelFromResponse($this->index);
		}

		return $hotel;
	}



	public function selectedRooms($combIndex)
	{
		$rooms = [];

		if (isset($this->response->GetHotelRoomResult->RoomCombinations->RoomCombination[$combIndex])) {
			$combination = $this->response
										->GetHotelRoomResult
											->RoomCombinations
												->RoomCombination[$combIndex];
			foreach ($combination->RoomIndex as $roomIndex) {
				$rooms[] = $this->getRoomByRoomIndex($roomIndex);
			}
		}

		return $rooms;	
	}


	public function getRoomByRoomIndex($roomIndex)
	{
		$index = array_search($roomIndex, 
							array_column($this->response
								->GetHotelRoomResult
									->HotelRoomsDetails, 'RoomIndex'));

		return $this->response->GetHotelRoomResult
									->HotelRoomsDetails[$index];

	}


	public function makeRoomBlockRequest(Array $indexes)
	{
		if (!is_int_array($indexes)) return null;

		$req = null;

		$hotel = $this->hotel();
		$hotelRequest = $this->hotels->request;

		if (!is_null($hotel) && !is_null($hotelRequest)) {
			
			$req = [
					"ResultIndex" => $hotel->ResultIndex,
					"HotelCode" => $hotel->HotelCode,
					"HotelName" => $hotel->HotelName,
					"GuestNationality" => $hotelRequest->GuestNationality,
					"NoOfRooms" => $hotelRequest->NoOfRooms,
					"ClientReferenceNo" => "0",
					"IsVoucherBooking" => "true",
					"EndUserIp" => $hotelRequest->EndUserIp,
					"TokenId" => $hotelRequest->TokenId,
					"TraceId" => $this->request->TraceId,
					"HotelRoomsDetails" => []
				];

			foreach ($indexes as $index) {

				$room = $this->response->GetHotelRoomResult
												->HotelRoomsDetails[$index];

				/*$bedTypeCode = isset($room->BedTypes->BedTypeCode)
										 ? $room->BedTypes->BedTypeCode
										 : null;*/

				$req['HotelRoomsDetails'][] = [
									"RoomIndex" 	 => $room->RoomIndex,
									"RoomTypeCode" => $room->RoomTypeCode,
									"RoomTypeName" => $room->RoomTypeName,
									"RatePlanCode" => $room->RatePlanCode,
									"BedTypeCode"	 => null,
									"Supplements"  => null,
									"SmokingPreference" => 0,
									"Price" => (array) $room->Price,
							];

			}
		}

		return $req;
	}


}
