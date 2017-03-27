<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'admins';
}
