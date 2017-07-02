<?php

namespace App\Models\ItineraryApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\PayuPaymentModel;

class PaymentModel extends Model
{
	protected $connection = 'mysql8';
	protected $table = 'payments';

	public function findByTokenOrFail($token)
	{
		return $this->where(['token' => $token])->firstOrFail();
	}

	public function payuPayment()
	{
		return $this->morphOne(PayuPaymentModel::class, 'payable');
	}
		
}
