<?php

namespace App\Models\TravelerApp;

use Illuminate\Database\Eloquent\Model;

class MyBookingModel extends Model
{
	protected $connection = 'mysql9';
	protected $table = 'my_bookings';

	public function setTravelerIdAttribute()
	{
		if (is_null($this->traveler_id)) {
			$this->attributes['traveler_id'] = auth()->guard('traveler')
																								->user()->id;
		}
	}

	public function setTokenAttribute()
	{
		if (is_null($this->token)){
			$this->attributes['token'] = new_token();
		}
	}



	public function scopeByToken($query, $token)
	{
		return $query->where('token', '=', $token);
	}


	public function bookedTo()
	{
		return $this->morphTo();
	}


	public function openUrl()
	{
		return route('traveler.booking.detail', $this->token);
	}


	public function voucherUrl()
	{
		return route('traveler.booking.voucher', $this->token);
	}


	public function cancelUrl()
	{
		return route('traveler.booking.cancel', $this->token);
	}


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		$this->setTravelerIdAttribute();
		parent::__construct($attributes);
	}

}
