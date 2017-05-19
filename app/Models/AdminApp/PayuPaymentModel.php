<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;

class PayuPaymentModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'payu_payments';
	protected $casts = ['data' => 'object'];

	public function findByTxnid($txnId)
	{
		return $this->where(['txnid' => $txnId])->first();
	}

}
