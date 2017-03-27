<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class VendorDetailModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'vendor_details';
}
