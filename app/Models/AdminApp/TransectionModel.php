<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;

class TransectionModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'transections';
}
